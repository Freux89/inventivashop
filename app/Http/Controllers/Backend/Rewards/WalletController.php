<?php

namespace App\Http\Controllers\Backend\Rewards;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:wallet_configurations'])->only('configurations');
    }

    # rewards configuration
    public function configurations()
    {
        return view('backend.pages.rewards.walletConfigurations');
    }
}
