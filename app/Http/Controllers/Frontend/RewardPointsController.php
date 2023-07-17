<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RewardPoint;
use App\Models\WalletHistory;
use Illuminate\Http\Request;

class RewardPointsController extends Controller
{
    # all rewards
    public function index()
    {
        $rewards = auth()->user()->rewards()->latest()->paginate(paginationNumber());
        return getView('pages.users.rewards', ['rewards' => $rewards]);
    }


    # convert reward to wallet
    public function convert($id)
    {
        $reward = RewardPoint::where('id', decrypt($id))->where('user_id', auth()->user()->id)->first();

        if (!is_null($reward)) {
            $waitingDays = (int) getSetting('waiting_days_for_wallet_conversion');
            $checkDate = \Carbon\Carbon::parse($reward->created_at)->addDays($waitingDays);
            $today = today();
            $count = $checkDate->diffInDays($today);

            if ($count > 0) {
                flash(localize('You can not convert this now'))->info();
            } else {
                # convert to wallet
                $pointsPerUsd = (float) getSetting('reward_points_per_usd'); // 1usd = n pts
                $amount =  $reward->total_points / $pointsPerUsd;
                $wallet = new WalletHistory;
                $wallet->user_id = auth()->user()->id;
                $wallet->amount = $amount;
                $wallet->payment_method = "Converted Rewards";
                $wallet->save();

                $reward->is_converted = 1;
                $reward->save();

                $user = auth()->user();
                $user->user_balance += $wallet->amount;
                $user->save();

                flash(localize('Converted to wallet balance'))->success();
            }
        } else {
            flash(localize('Not found'))->error();
        }
        return back();
    }
}
