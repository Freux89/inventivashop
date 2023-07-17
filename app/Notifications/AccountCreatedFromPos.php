<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use App\Mail\EmailManager;
use Auth;
use App\Models\User;

class AccountCreatedFromPos extends Notification
{
    use Queueable;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        $array['view'] = 'emails.newAccount';
        $array['subject'] = localize('Account Created');
        $array['content'] = localize('Your account has been created. Please visit our website & reset your password');
        $array['email'] = $this->user->email;
        $array['email'] = $this->user->email;
        $array['link'] = route('home');

        return (new MailMessage)
            ->view('emails.newAccount', ['array' => $array])
            ->subject(localize('Account Created - ') . env('APP_NAME'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
