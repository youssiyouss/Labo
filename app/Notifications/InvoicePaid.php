<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Rfp;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Rfp $rfp)
    {
       $this->rfp = $rfp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
     public function toMail($notifiable)
     {
       return (new MailMessage)->view('emails.view', ['rfp' => $this->rfp])
                               ->from('LRIT@gmail.com', 'Laboratoire de Recherche Informatique -Tlemcen');
                               ->subject('Date échenace expirée!')
     }

     public function toDatabase()
     {
           return[
              'amount' => 48,
              'invoice_action' => 'Pay now..!',
           ];
     }
     public function viaQueues()
     {
          return [
              'mail' => 'mail-queue',
              'database' => 'database-queue',
          ];
      }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
