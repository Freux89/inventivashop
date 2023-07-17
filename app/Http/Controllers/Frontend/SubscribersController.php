<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\SubscribedUser;
use App\Http\Controllers\Controller;

class SubscribersController extends Controller
{
    # store new subscribers
    public function store(Request $request)
    {
        $subscriber = SubscribedUser::where('email', $request->email)->first();
        if($subscriber == null){
            $subscriber = new SubscribedUser;
            $subscriber->email = $request->email;
            $subscriber->save();
            flash(localize('You have subscribed successfully'))->success();
        }
        else{
            flash(localize('You are  already a subscriber'))->error();
        }
        return back();
    }
}
