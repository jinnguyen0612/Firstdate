<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class AccountActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $activationUrl = URL::temporarySignedRoute(
            'user.activationindex',
            now()->addMinutes(30),
            [
                'token' => $this->user->token_active_account,
                'code' => $this->user->code,
            ]
        );

        return $this->subject('Kích hoạt tài khoản')
            ->view('mails.account-activation')
            ->with([
                'url' => $activationUrl,
                'user' => $this->user
            ]);
    }
}
