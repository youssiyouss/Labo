<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //Mark a notification as read

    public function readNotification($id)
    {
        $url = auth()->user()->notifications->find($id);
        if ($url->read_at == NULL) {
            auth()->user()->unreadNotifications->find($id)->markAsRead();
        }
        return redirect('alerte/'.$id);
    }


    //Display notification details
    public function displaytNotif($id)
    {
        $url = auth()->user()->readNotifications->find($id);

        $date = $url->created_at;
        return view('alerts.index', ['notif' => $url, 'date' => $date]);
    }

    // Return Alertes Page
    public function index()
    {
        $alerts = DB::table('notifications')->get();

        return view('Alerts.index',['notification'=> $alerts]);
    }


    public function destroyAll()
    {
        DB::table('notifications')->delete();

        return view('Alerts.index')->with('danger', 'Notifications Supprimées!');
    }


}
