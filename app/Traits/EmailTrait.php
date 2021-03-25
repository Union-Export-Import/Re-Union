<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait EmailTrait
{
    public function sendUserCreationEmail($user, $auto_pwd)
    {
        $emailData = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> <html> <head> <META http-equiv="Content-Type" content="text/html; charset=utf-8"> </head> <body> <div align="center"> <table> <tbody> <tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td valign="top"> <a href="https://www.educationhost.co.uk" target="_blank"> <img src="https://lh3.googleusercontent.com/CNOXtONIfD7Q4tdvAMFmKMcJjob80emWZ75is5BEHkB1xhQSAF31AzdGyILiSmBX5imT6xi9hlb2C9O6M3myvQb_J_jNAdBIX2QqgBzAK6WC3QF4PY_1L80HotbhFvlkuMlxRgJuEMCOlBHJ-usE4RbE6m1NqHHAcsdNIBvX2YTw8ZszSPLl4jSepbD9EKmzAl1mYXalE-fg6kS98euH7pHuNLwirA9AwN6Mf2qAff9zHP2xaR9HR02yOH_ChBzPYf_-HzXl57Cdlypd6Eb2zamPXnkIM3MNXq3YMR_Aj2n5ERKYKqxGP9imSW1a8jxRJY4NbT3L2PaX-gQNnPXWXIS7boBlhYqTs5psznbjiIzm0wOeulg_0D63aZhpRaciv1P8l417AdS9_SHt8UkzvdnP2vkBzbq7-QzZS7lRaNJx9C0JBBqKf9j9YrV7KIc7KvyyR2qlW1j2_nZ54je-KYtBO_YmSnqPJb6w6D7RfIKrqDqwZHBSB6McX_vE5eY8Pmc7TdYimW-nlGa_QijDaPQ-07Bvnnmzj5DZKoDPxxFNYT6HjIRIgog7wQXZ7GLA9KY-eyIi5I6YsFUdeTyQXvEaXkXdCISCn4sxSZH1jV6Nbw6XectjtPSYPIRRwYCiqSIoPXo18VHdsYMA_Nch-buoKQZUIbW8RdcZi3TQcvETxUPMJSLo2Zf80bnO=w553-h174-no?authuser=0" style="max-width:400px;padding:20px" alt="Education Host"> </a></td> </tr> </tbody> </table> </td> </tr> <tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td valign="top"> <p>Welcome to Union-Export-Import Dashboard</p> <p>email - ' . $user->email . '</p> <p>password - ' . $auto_pwd . '</p> <p>Union Export/Import Co.Ltd</p> </td> </tr> </tbody> </table> </td> </tr> <tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td valign="top"> <a href="https://www.educationhost.co.uk" target="_blank">visit our website</a> <span> | </span> <a href="https://www.educationhost.co.uk/whmcs/" target="_blank">log in to your account</a> <span> | </span> <a href="https://www.educationhost.co.uk/whmcs/submitticket.php" target="_blank">get support</a> <br> Copyright © Union Export/Import, All rights reserved. </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </div> </body> </html>';

        Mail::send([], [], function ($message) use ($emailData, $user) {
            $message->to($user->email, $user->name)->subject('Welcome new user')->setBody($emailData, 'text/html');
            $message->from(env("MAIL_FROM_ADDRESS", "unionexportimportmm@gmail.com"), env("MAIL_FROM_NAME", "Union-Export-Import"));
        });
    }

    public function emailSend($request)
    {
        $emailData = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> <html> <head> <META http-equiv="Content-Type" content="text/html; charset=utf-8"> </head> <body> <div align="center"> <table> <tbody> <tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td valign="top"> <a href="https://www.educationhost.co.uk" target="_blank"> <img src="https://lh3.googleusercontent.com/CNOXtONIfD7Q4tdvAMFmKMcJjob80emWZ75is5BEHkB1xhQSAF31AzdGyILiSmBX5imT6xi9hlb2C9O6M3myvQb_J_jNAdBIX2QqgBzAK6WC3QF4PY_1L80HotbhFvlkuMlxRgJuEMCOlBHJ-usE4RbE6m1NqHHAcsdNIBvX2YTw8ZszSPLl4jSepbD9EKmzAl1mYXalE-fg6kS98euH7pHuNLwirA9AwN6Mf2qAff9zHP2xaR9HR02yOH_ChBzPYf_-HzXl57Cdlypd6Eb2zamPXnkIM3MNXq3YMR_Aj2n5ERKYKqxGP9imSW1a8jxRJY4NbT3L2PaX-gQNnPXWXIS7boBlhYqTs5psznbjiIzm0wOeulg_0D63aZhpRaciv1P8l417AdS9_SHt8UkzvdnP2vkBzbq7-QzZS7lRaNJx9C0JBBqKf9j9YrV7KIc7KvyyR2qlW1j2_nZ54je-KYtBO_YmSnqPJb6w6D7RfIKrqDqwZHBSB6McX_vE5eY8Pmc7TdYimW-nlGa_QijDaPQ-07Bvnnmzj5DZKoDPxxFNYT6HjIRIgog7wQXZ7GLA9KY-eyIi5I6YsFUdeTyQXvEaXkXdCISCn4sxSZH1jV6Nbw6XectjtPSYPIRRwYCiqSIoPXo18VHdsYMA_Nch-buoKQZUIbW8RdcZi3TQcvETxUPMJSLo2Zf80bnO=w553-h174-no?authuser=0" style="max-width:400px;padding:20px" alt="Education Host"> </a></td> </tr> </tbody> </table> </td> </tr> <tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td valign="top"> <p>Welcome to Union-Export-Import Dashboard</p> <p>email - ' . $request['body'] . '</p><p>Union Export/Import Co.Ltd</p> </td> </tr> </tbody> </table> </td> </tr> <tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td valign="top"> <a href="https://www.educationhost.co.uk" target="_blank">visit our website</a> <span> | </span> <a href="https://www.educationhost.co.uk/whmcs/" target="_blank">log in to your account</a> <span> | </span> <a href="https://www.educationhost.co.uk/whmcs/submitticket.php" target="_blank">get support</a> <br> Copyright © Union Export/Import, All rights reserved. </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </div> </body> </html>';
        // dd($request['to']);
        foreach ($request['to'] as  $to) {
            Mail::send([], [], function ($message) use ($emailData, $request, $to) {
                $message->to($to, $request['name'])->subject($request['subject'])->setBody($emailData, 'text/html');
                $message->from(env("MAIL_FROM_ADDRESS", "unionexportimportmm@gmail.com"), env("MAIL_FROM_NAME", "Union-Export-Import"));
                $message->attach($request['attachment'], [
                    'as' => $request['attachment']
                ]);
            });
        }
    }
}
