<?php

namespace App\Http\Controllers;


use Auth;

class NotificationController extends Controller
{
    //Mark a notification as read

    public function readNotification($id)
    {
        auth()->user()->unreadNotifications->find($id)->markAsRead();
        if(auth()->user()->unreadNotifications->find($id)->data['alert']['voir'] ){
            return redirect(auth()->user()->unreadNotifications->find($id)->data['alert']['voir']);
        }
        else{

            return redirect('alerte');
        }
    }


    //Display notification details
    public function index()
    {
        return view('alerts.index');
    }

    public function delete($id)
    {
        Auth::user()->notifications()->find($id)->delete();

        Session()->flash('successs', 'Notification supprimée !');
        return redirect('alerte');
    }
    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        Session()->flash('successs', 'Toutes les notifications ont été supprimé avec succées !');
        return redirect('alerte');
    }
    public function clearAll()
    {
        $user = Auth::user();
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        Session()->flash('successs', 'Toutes les notifications ont été marquée comme lu !');
        return redirect('alerte');
    }

}
