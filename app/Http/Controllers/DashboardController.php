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

	public function userupdate($value) {
		if ($value == 0 || $value == 1)
		{
			DB::table('tuteurs_users')
			->where('login', session()->get('username'))
			->update(['notif' => $value]);
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
				$username = trim(addslashes(htmlspecialchars($username)));
				$user = $this->getUser($username);

				if(isset($user->login))
					$exist = true;
				else
					$exist = false;
			}

			if ($exist == true)
			{
				$tutor = $this->getTutor($username);

			}
			else
			{
				$tutor = null;
			}
			return view('user.profileUser', ['exist' => $exist,'user' => $user, 'tutor' => $tutor]);
		}
	}

	private function getUser($username){
		$token = session()->get('token');
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
		return (json_decode($result));
	}

	private function getTutor($username){
		$tutor = DB::table('tuteurs_users')
		->where('tuteurs_users.login', $username)
		->first();

		return($tutor);
	}

	public function events()
	{
		if(!session()->exists('username'))
			return redirect()->route('login');
		else if(session()->get('tutor') == false)	
			return redirect()->route('home');
		else
		{
			$today = date("Y-m-d");
			$events = DB::table('tuteurs_events')
			->where(DB::raw('count(*) from `tuteurs_event_commentaires` where tuteurs_event_commentaires.event_id = tuteurs_events.event_id as comments, *'))
			->get();
			var_dump($events);
		}
	}
}