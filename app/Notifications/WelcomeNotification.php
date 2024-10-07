<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Benvenuto su ' . config('app.name') . '!')
                    ->greeting('Ciao ' . $notifiable->name . '!')
                    ->line('Siamo entusiasti di darti il benvenuto su ' . config('app.name') . '! La tua registrazione è avvenuta con successo e ora fai parte del nostro esclusivo gruppo di clienti.')
                    ->line('Con il tuo account su ' . config('app.name') . ' potrai accedere a una serie di vantaggi, tra cui:')
                    ->line('- Offerte speciali e promozioni riservate solo ai nostri clienti registrati.')
                    ->line('- Gestione facile dei tuoi ordini e personalizzazione delle preferenze di acquisto.')
                    ->line('- Accesso prioritario ai nostri nuovi prodotti e collezioni.')
                    ->action('Inizia a esplorare', url('/'))
                    ->line('Per iniziare al meglio, ti consigliamo di completare il tuo profilo e dare un’occhiata alle ultime novità sul nostro sito.')
                    ->line('Se hai bisogno di assistenza o hai domande, il nostro team è sempre a tua disposizione. Puoi contattarci direttamente dal sito.')
                    ->line('Grazie ancora per aver scelto ' . config('app.name') . '! Non vediamo l’ora di offrirti la migliore esperienza di acquisto.')
                    ->salutation('Cordiali saluti,')
                    ->salutation('Il Team di ' . config('app.name'));
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
