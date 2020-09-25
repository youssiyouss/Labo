<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Email;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    //Return view of sended messages
    public function compose($id){
        $users =User::all();
        $from = User::find($id);
        $important = DB::table('emails')
            ->select('emails.*')
            ->where([['tag', 'Important'], ['to', Auth::user()->email]])
            ->count();
        $newMail = Email::where([['read_at', Null], ['to', Auth::user()->email]])->get();

        return view('emails.compose',[ 'unreadMails' => $newMail,'important' => $important, 'from' => $from->email ,'users' => $users]);
    }

    public function store(Request $request){
        $respos =  $request->input('to', array());

        foreach($respos as $receiver){

        $mail = new Email();
        $mail->to  = $receiver;
        $mail->from = $request->input('from');
        $mail->tag = $request->input('tag');
        $mail->subject = $request->input('subject');
        $mail->message = $request->input('tinymce');
            $mail->save();
        }
        if ($mail->save()) {
            Session()->flash('success', "Votre mail a été envoyé avec succés!!");
  /*          $mail = collect([
                'sybject' => $mail->subject,
                'to' =>  $mail->to,
                'from' =>  $mail->from,
                'message' => $mail->message
            ]);
            Mail::send(new welcomeMail($mail));
*/

        } else {
            Session()->flash('error', 'Envoi echouée!!');
        }
        return redirect('email/inbox');
    }


 public function transfer(Request $request,$id){
        $email = Email::find($id);
        $respos =  $request->input('to', array());
        foreach ($respos as $receiver) {

            $mail = new Email();
            $mail->to  = $receiver;
            $mail->from = $email->from;
            $mail->tag = $email->tag;
            $mail->subject = $email->subject;
            $mail->message = $email->message;
            $mail->save();
        }
        if ($mail->save()) {
            Session()->flash('success', "Votre mail a été transféré avec succés!!");

        } else {
            Session()->flash('error', 'Transfert echouée!!');
        }
        return redirect('email/inbox');
    }

    public function inbox(){

        $emails =Email::where('to', Auth::user()->email)->orderBy('created_at','desc')->get();
        $newMail = Email::where([['read_at', Null],['to',Auth::user()->email]])->get();
        $important = DB::table('emails')
            ->select('emails.*')
            ->where([['tag', 'Important'], ['to', Auth::user()->email]])
            ->count();

    	return view('emails.inbox', ['important' => $important, 'content' => $emails, 'unreadMails' => $newMail]);
    }


    public function inboxSent(){

        $emails = Email::where('from',Auth::user()->email)->orderBy('created_at','desc')->get();
        $newMail = Email::where([['read_at', Null], ['to', Auth::user()->email]])->get();
        $important = DB::table('emails')
            ->select('emails.*')
            ->where([['tag', 'Important'], ['to', Auth::user()->email]])
            ->count();
        return view('emails.inboxSent', ['important' => $important, 'content' => $emails, 'unreadMails' => $newMail]);
    }



    public function read($id){

        $content =Email::where('id', $id)->first();
        $newMail = Email::where('read_at', Null)->get();
        $sender = User::where('email',$content->from)->first();
        $important = DB::table('emails')
            ->select('emails.*')
            ->where([['tag', 'Important'], ['to', Auth::user()->email]])
            ->count();

        $users = User::all();
        DB::table('emails')->where('id', $id)
            ->update(
                ['read_at' => Carbon::now('Africa/Algiers')]
            );
       return view('emails.read', ['important' => $important, 'content' => $content, 'users' => $users,'sender' =>  $sender ,'unreadMails' => $newMail]);

    }


    public function markAsRead($id)
    {
        DB::table('emails')->where('id', $id)
        ->update(
            ['read_at' => Carbon::now('Africa/Algiers')]
        );
        return redirect('email/inbox');
    }


    public function clearAll($id)
    {

        DB::table('emails')->where('to', User::find($id)->email)
        ->update(
            ['read_at' => Carbon::now('Africa/Algiers')]
        );

        return redirect('email/inbox')->with('success', 'Tout vos email ont été marqué comme lu!');
    }



    public function markAsUnread($id)
    {
        DB::table('emails')->where('id', $id)
        ->update(
            ['read_at' => Null]
        );
        return redirect('email/inbox');
    }


    public function destroy($id)
    {
        $a = Email::find($id);
        $a->delete();

        return redirect('email/inbox')->with('success', 'Email supprimé avec succés!');
    }


    public function deleteAll($id)
    {

        $a = Email::where('to', User::find($id)->email)->delete();
        return redirect('email/inbox')->with('success', 'Tout vos email ont été supprimé avec succés!');
    }

    public function tags($id){

        $emails= DB::table('emails')
            ->select('emails.*')
            ->where([['tag', $id],['to',Auth::user()->email]])
            ->get();
        $important= DB::table('emails')
            ->select('emails.*')
            ->where([['tag', 'Important'],['to',Auth::user()->email]])
            ->count();
        $newMail = Email::where([['read_at', Null], ['to', Auth::user()->email]])->get();
         return view('emails.tags',[ 'important'=>$important,  'emails'=>$emails, 'titre'=>$id, 'unreadMails' => $newMail]);

    }


}
