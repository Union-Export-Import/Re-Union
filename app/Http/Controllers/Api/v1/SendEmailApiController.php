<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\EmailTrait;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailApiController extends Controller
{
    use EmailTrait, ResponserTrait;

    public function sendEmail(Request $request)
    {
        // dd($request->all());
        $this->emailSend($request);
        // Mail::send('email.sendEmail', $request, function ($message) use ($request) {
        //     $message->to($request["email"], $request["email"])
        //         ->subject($request["title"]);

        //     foreach ($request->attachment as $file) {
        //         $message->attach($file);
        //     }
        // });

        return $this->respondCreateMessageOnly('success');
    }
}
