<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index(){
		if(!session()->exists('username'))
			return redirect()->route('login');
		else if(session()->get('tutor') == false)	
			return redirect()->route('home');
		else
			return view('user.dashboardUser');
	}
}