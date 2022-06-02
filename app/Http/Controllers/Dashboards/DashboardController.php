<?php

namespace App\Http\Controllers\Dashboards;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        $userDashboard = User::where('email', Auth::user()->email)->first();
        return view('dashboard', ['userDashboard' => $userDashboard]);
    }
}
