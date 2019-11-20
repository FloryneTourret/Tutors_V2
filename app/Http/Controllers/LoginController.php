<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

	private $client_id;
	private $client_secret;
	private $redirect_uri;
	private $token;
	private $error;

	public function index(){
		if(!session()->exists('username'))
		{
			$this->client_id = env('API42_UID');
			$this->client_secret = env('API42_SECRET');
			$this->redirect_uri= env('API42_REDIRECT');
			
			if(isset($_GET['code']) && ctype_alnum($_GET['code']))
			{
				if(session()->exists('token')){
					$this->token = session()->get('token');
					$this->getUser();
				}
				else if($this->getToken() == 0)
					$this->getUser();
				else
					return redirect()->route('login');
				
				if(session()->exists('username'))
				{
					if(($user = DB::table('tuteurs_users')->where('login', session()->get('username') )->first()) != NULL)
						session(['tutor' => true, 'notif' => $user->notif, 'admin' => $user->admin]);
					else
						session(['tutor' => false]);
					return redirect()->route('home');
				}
			}
			return view('user.login');
		}
		else
			return redirect()->route('home');
	}

	private function getToken(){

		$authorization_code = trim(addslashes(htmlspecialchars($_GET['code'])));
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, 'https://api.intra.42.fr/oauth/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=$authorization_code&redirect_uri=$this->redirect_uri&client_id=$this->client_id&client_secret=$this->client_secret");
		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);

		$array = json_decode($result);
		if(isset($array->error))
		{
			$this->error = $array->error;
			return(1);
		}
		else{
			$this->token = $array->access_token;
			session(['token' => $this->token]);
			return(0);
		}
	}

	private function getUser(){

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, 'https://api.intra.42.fr/v2/me');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		$headers = array();
		$headers[] = 'Authorization: Bearer '.$this->token;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		$array = json_decode($result);
		session(['user' => $result, 'username' => $array->login, 'email' => $array->email]);
	}
}