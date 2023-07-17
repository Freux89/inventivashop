<?php

namespace App\Http\Controllers\Backend\MediaManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaManagerController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:media_manager'])->only('index');
    }
    
    # get media files
    public function index()
    {
        return view('backend.pages.mediaManager.index');
    }
}
