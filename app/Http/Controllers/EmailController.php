<?php

namespace App\Http\Controllers;

use App\Email;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Webklex\IMAP\Facades\Client;
class EmailController extends Controller
{
    public function sendMail(Request $request)
    {
        global $userId;
        $file[]=$request->attachment;
        if (isset($request->attachment) && count($request->attachment)) {
            foreach ($request->attachment as $attachment) {
                rename(public_path('uploads/junk/' . $attachment),public_path('uploads/attcahments/'.$attachment));
            }
        }
        $data["to"] = $request->to;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $userId=Auth::id();
        $email=new Email();
        $email->to=$request->to;
        $email->message=$request->message;
        $email->subject=$request->subject;
        $email->attachment=$request->attachment? implode(",", $request->attachment):'';
        $email->user_id=$userId;
        $email->created_at=Carbon::now();
        $email->save();
        Mail::send('email.send', $data, function($message)use($data,$file) {
            $message->to($data["to"], $data["to"])
                ->subject($data["subject"]);

            if (isset($file) && count($file)) {
                foreach ($file as $attachments) {
                    $message->attach($attachments);
                }
            }

        });
        toastr()->success('ایمیل با موفقیت ارسال شد');
        return back();
    }
    public function listSendEmail()
    {
        global $userId;
        $userId=Auth::id();
        $email=Email::with("user")->where('user_id',$userId)->where('send',1)->paginate(20);
        $count=Email::with("user")->where('user_id',$userId)->where('send',1)->count();
        return view('email.send-list',compact('email','count'));
    }
    public function showDetailsSend($id)
    {
        $email=Email::with("user")->find($id);
        return view('email.send-details',compact('email'));

    }


}
