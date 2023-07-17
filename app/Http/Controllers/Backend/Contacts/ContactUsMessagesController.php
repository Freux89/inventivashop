<?php

namespace App\Http\Controllers\Backend\Contacts;

use App\Http\Controllers\Controller;
use App\Models\ContactUsMessage;

class ContactUsMessagesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:contact_us_messages'])->only('index');
    }

    # get all query messages
    public function index()
    {
        $messages = ContactUsMessage::orderBy('is_seen', 'ASC')->latest()->paginate(paginationNumber());
        return view('backend.pages.queries.index', compact('messages'));
    }

    # make message read
    public function read($id)
    {
        $message = ContactUsMessage::where('id', $id)->first();

        if ($message->is_seen == 0) {
            $message->is_seen = 1;
            flash(localize('Marked as read'))->success();
        } else {
            $message->is_seen = 0;
            flash(localize('Marked as unread'))->success();
        }
        $message->save();
        return back();
    }
}
