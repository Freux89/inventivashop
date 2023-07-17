<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RewardPoint;
use App\Models\WalletHistory;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    # all wallet histories
    public function index()
    {
        $wallets = auth()->user()->wallets()->latest()->paginate(paginationNumber());
        return getView('pages.users.walletHistory', ['wallets' => $wallets]);
    }
}
