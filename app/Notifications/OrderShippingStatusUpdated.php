<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippingStatusUpdated extends Notification
{
    use Queueable;

    protected $order; // Aggiungi questa riga

    /**
     * Create a new notification instance.
     *
     * @param $order // Aggiungi il parametro $order
     * @return void
     */
    public function __construct($order) // Modifica il costruttore per accettare l'ordine
    {
        $this->order = $order; // Assegna l'ordine alla proprietà della classe
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
        ->subject('Aggiornamento Stato Spedizione Ordine #' . $this->order->order_group_id)
        ->greeting('Ciao ' . $notifiable->name . ',')
        ->line('Lo stato di spedizione del tuo ordine #' . $this->order->order_group_id . ' è stato aggiornato.')
        ->line('Nuovo stato di spedizione: ' . ucfirst($this->order->payment_status))
        ->action('Visualizza Ordine', url('/orders/invoice/' . $this->order->order_group_id))
        ->line('Grazie per aver scelto il nostro negozio!')
        ->salutation(env('APP_NAME') . ' Team');
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
