<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function index(){
		if(!session()->exists('username'))
			return redirect()->route('login');
		else
			return view('home');
	}
}