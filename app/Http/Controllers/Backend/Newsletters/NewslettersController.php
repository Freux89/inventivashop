<?php

namespace App\Http\Controllers\Backend\Newsletters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubscribedUser;
use Mail;
use App\Mail\EmailManager;

class NewslettersController extends Controller
{
    # construct
    public function __construct()
    { 
        $this->middleware(['permission:newsletters'])->only(['index', 'sendNewsletter']);   
    }
    
    # newsletter sending page
    public function index(Request $request)
    {
        $users = User::where('user_type' , '!=', 'admin')->where('user_type', '!=' , 'staff')->get();
        $subscribers = SubscribedUser::all();
        return view('backend.pages.newsletters.index', compact('users', 'subscribers'));
    }

    # send newsletter
    public function sendNewsletter(Request $request)
    {
        if (env('MAIL_USERNAME') != null) {
            //sends newsletter to subscribed users
            if ($request->has('subscriber_emails')) {
                foreach ($request->subscriber_emails as $key => $email) {
                    $array['view'] = 'emails.bulkEmail';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->content; 
                    try {
                        Mail::to($email)->queue(new EmailManager($array));
                    } catch (\Exception $e) {
                        // 
                    }
            	}
            }

            //sends newsletter to users
        	if ($request->has('user_emails')) {
                foreach ($request->user_emails as $key => $email) {
                    $array['view'] = 'emails.bulkEmail';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->content;

                    try {
                        Mail::to($email)->queue(new EmailManager($array));
                    } catch (\Exception $e) {
                        // 
                    }
            	}
            } 
        } else {
            flash(localize('Please configure SMTP first'))->error();
            return back();
        }

    	flash(localize('Newsletter has been sent'))->success();
    	return back();
    } 
}
