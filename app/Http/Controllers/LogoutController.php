<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
	public function index(){
		session()->flush();
		return redirect()->route('login');
	}
}