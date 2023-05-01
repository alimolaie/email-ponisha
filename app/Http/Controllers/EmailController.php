<?php

namespace App\Http\Controllers;

use App\Email;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
class EmailController extends Controller
{
    public function sendMail(Request $request)
    {
        global $userId;
        $userId=Auth::id();
        $email=new Email();
        $email->to=$request->to;
        $email->message=$request->message;
        $email->subject=$request->subject;
        $email->user_id=$userId;
        $email->created_at=Carbon::now();
        $email->save();
        Mail::to($request->to)->send(new SendEmail($request->input('to'), $request->input('subject'),$request->message));
        toastr()->success('ایمیل با موفقیت ارسال شد');
        return back();
    }
    public function listSendEmail()
    {
        global $userId;
        $userId=Auth::id();
        $email=Email::with("user")->where('user_id',$userId)->where('send',1)->paginate(20);
        return view('email.send-list',compact('email'));
    }
}
