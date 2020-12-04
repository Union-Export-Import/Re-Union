<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait EmailTrait
{
    public function sendUserCreationEmail($message, $data)
    {
        $emailData = '<html> <p>Dear All,<br /> There is a new lucky draw please check your system and Lucky draw credentials are as follows.<br /><br />Customer Name &ndash; ' . 'Aung' . '<br /><br />Phone Number &ndash; ' . '09789333573' . '<br /><br />Status &ndash; Next Purchase<br /><br />Lucky Draw Amount &ndash; ' . 'gg' . '<br /><br />Product Code &ndash; ' . 'jfiweoojfw' . '</p> </html>';

        Mail::send([], [], function ($message) use ($emailData) {
            $message->to(env("MAIL_FROM_ADDRESS", "unionexportimportmm@gmail.com"), env("MAIL_FROM_NAME", "Union-Export-Import"))->subject('Welcome new user')->setBody($emailData, 'text/html');
            $message->from('unionexportimport@gmail.com', 'Admin');
        });
    }
}
