<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $tempPassword)
    {
        $this->user = $user;
        $this->password = $tempPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.user-credentials')
                    ->subject('Vos identifiants de connexion - Restaurant App')
                    ->with([
                        'user' => $this->user,
                        'password' => $this->password,
                    ]);
    }
}
