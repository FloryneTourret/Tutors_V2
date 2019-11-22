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
		{
			$today = date("Y-m-d H:i:s");
			$myEventsOn = DB::table('tuteurs_events')
			->join('tuteurs_event_participant', 'tuteurs_event_participant.id_event', '=', 'tuteurs_events.event_id')
			->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_event_participant.id_user')
			->where('tuteurs_users.login', session()->get('username'))
			->where('date_fin', '>=', $today)
			->get();

			$myEvents = DB::table('tuteurs_events')
			->join('tuteurs_event_participant', 'tuteurs_event_participant.id_event', '=', 'tuteurs_events.event_id')
			->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_event_participant.id_user')
			->where('tuteurs_users.login', session()->get('username'))
			->get();

			$mySuggestions = DB::table('tuteurs_suggestions')
			->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_suggestions.id_user')
			->where('tuteurs_users.login', session()->get('username'))
			->get();

			$myHelpSessions = DB::table('tuteurs_suivi')
			->join('tuteurs_users', function ($join) {
				$join->on('tuteurs_suivi.id_user1', '=', 'tuteurs_users.user_id')
				->orOn('tuteurs_suivi.id_user2', '=', 'tuteurs_users.user_id');
			})
			->where('tuteurs_users.login', session()->get('username'))
			->get();

			$myHelpSessionsOn = DB::table('tuteurs_suivi')
			->join('tuteurs_users', function ($join) {
				$join->on('tuteurs_suivi.id_user1', '=', 'tuteurs_users.user_id')
				->orOn('tuteurs_suivi.id_user2', '=', 'tuteurs_users.user_id');
			})
			->where('tuteurs_users.login', session()->get('username'))
			->where('tuteurs_suivi.resolu', 0)
			->get();

			$lastSuggestions = DB::table('tuteurs_suggestions')
			->latest()
			->limit(5)
			->get();

			$lastEvents = DB::table('tuteurs_events')
			->latest()
			->limit(5)
			->get();

			
			return view('user.dashboardUser', ['myEventsOn' => $myEventsOn,
												'myEvents' => $myEvents,
												'mySuggestions' => $mySuggestions,
												'myHelpSessions' => $myHelpSessions,
												'myHelpSessionsOn' => $myHelpSessionsOn,
												'lastSuggestions' => $lastSuggestions,
												'lastEvents' => $lastEvents]);
		}
	}


	public function user($username = null){
		if(!session()->exists('username'))
			return redirect()->route('login');
		else if(session()->get('tutor') == false)	
			return redirect()->route('home');
		else
		{
			if($username == null){
				$username = session()->get('username');
				$user = json_decode(session()->get('user'));
				$exist = true;
			}
			else{
				$token = session()->get('token');
				$username = trim(addslashes(htmlspecialchars($username)));
				$ch = curl_init();
		
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_URL, 'https://api.intra.42.fr/v2/users/'.$username);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

				$headers = array();
				$headers[] = 'Authorization: Bearer '.$token;
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close ($ch);
				$user = json_decode($result);
				if(isset($user->login))
					$exist = true;
				else
					$exist = false;
			}
			return view('user.profileUser', ['exist' => $exist,'user' => $user]);
		}
	}
}