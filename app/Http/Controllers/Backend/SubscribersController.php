<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\SubscribedUser;
use App\Http\Controllers\Controller;

class SubscribersController extends Controller
{
    # construct
    public function __construct()
    { 
        $this->middleware(['permission:subscribers'])->only(['index']);   
    }
    
    # get subscribers
    public function index(Request $request)
    { 
        $searchKey = null;
        $subscribers = SubscribedUser::latest();
        if ($request->search != null) {
            $subscribers = $subscribers->where('email', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $subscribers = $subscribers->paginate(paginationNumber());
        return view('backend.pages.subscribers.index', compact('subscribers', 'searchKey'));
    }

    # delete subscribers
    public function delete($id)
    {  
        SubscribedUser::destroy($id);  
        flash(localize('Subscriber has been deleted successfully'))->success();
        return back();
    }
}
