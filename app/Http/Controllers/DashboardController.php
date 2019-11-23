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
			$myEventsOn = $this->getMyEventsOn(session()->get('username'));
			$myEvents = $this->getMyEvents(session()->get('username'));
			$mySuggestions = $this->getMySuggestions(session()->get('username'));
			$myHelpSessions = $this->getMyHelpSessions(session()->get('username'));
			$myHelpSessionsOn = $this->getMyHelpSessionsOn(session()->get('username'));

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
			->select('*', 
				DB::raw('(select count(*) from tuteurs_event_commentaires where tuteurs_event_commentaires.event_id = tuteurs_events.event_id) as comments_count'), 
				DB::raw('(select count(*) from tuteurs_event_orga where tuteurs_event_orga.event_id = tuteurs_events.event_id) as orga_count'),
				DB::raw('(select count(*) from tuteurs_event_like where tuteurs_event_like.event_id = tuteurs_events.event_id) as like_count'))
			->leftJoin('tuteurs_event_lead', 'tuteurs_event_lead.id_event', '=', 'tuteurs_events.event_id')
			->leftJoin('tuteurs_users', 'tuteurs_event_lead.id_user', '=', 'tuteurs_users.user_id')
			->where('tuteurs_events.date_fin', '>=', $today)
			->latest()
			->get();
			return view('user.events', ['events' => $events]);
		}
	}

	public function event($id) {
		if ($id) {
			$event = DB::table('tuteurs_events')
			->where('event_id', $id)
			->first();
			if ($event) {
				$id_event = $event->event_id;
				$comments = DB::table('tuteurs_event_commentaires')
				->join('tuteurs_users', 'tuteurs_event_commentaires.user_id', '=', 'tuteurs_users.user_id')
				->where('event_id', $id_event)
				->get(['id', 'commentaire', 'commentaire_date', 'login']);

				$lead = DB::table('tuteurs_event_lead')
				->join('tuteurs_users', 'tuteurs_event_lead.id_user', '=', 'tuteurs_users.user_id')
				->where('id_event', $id_event)
				->get('login');
				
				$likes = DB::table('tuteurs_event_like')
				->join('tuteurs_users', 'tuteurs_event_like.user_id', '=', 'tuteurs_users.user_id')
				->where('event_id', $id_event)
				->get('login');

				$orga = DB::table('tuteurs_event_orga')
				->join('tuteurs_users', 'tuteurs_event_orga.user_id', '=', 'tuteurs_users.user_id')
				->where('event_id', $id_event)
				->get(['id', 'commentaire', 'commentaire_date', 'login']);

				$contributors = DB::table('tuteurs_event_participant')
				->join('tuteurs_users', 'tuteurs_event_participant.id_user', '=', 'tuteurs_users.user_id')
				->where('id_event', $id_event)
				->get('login');
				
				return view('user.event', ['event' => $event,
											'comments' => $comments,
											'lead' => $lead,
											'likes' => $likes,
											'orga' => $orga,
											'contributors' => $contributors
				]);
			}
			else 
				return view('user.event', ['error' => "Désolé, cet event n'existe pas."]);
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
				$EventsOn = $this->getMyEventsOn($username);
				$Events = $this->getMyEvents($username);
				$Suggestions = $this->getMySuggestions($username);
				$HelpSessions = $this->getMyHelpSessions($username);
			}
			else
			{
				$tutor = null;
				$EventsOn = null;
				$Events = null;
				$Suggestions = null;
				$HelpSessions = null;
			}
			return view('user.profileUser', ['exist' => $exist,
											'user' => $user, 
											'tutor' => $tutor,
											'eventsOn' => $EventsOn,
											'events' => $Events,
											'suggestions' => $Suggestions,
											'helpSessions' => $HelpSessions
											]);
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

	private function getMyEventsOn($username){
		$today = date("Y-m-d H:i:s");
		$data = DB::table('tuteurs_events')
		->join('tuteurs_event_participant', 'tuteurs_event_participant.id_event', '=', 'tuteurs_events.event_id')
		->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_event_participant.id_user')
		->where('tuteurs_users.login', $username)
		->where('date_fin', '>=', $today)
		->get();
		return $data;
	}

	private function getMyEvents($username){
		$data = DB::table('tuteurs_events')
		->join('tuteurs_event_participant', 'tuteurs_event_participant.id_event', '=', 'tuteurs_events.event_id')
		->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_event_participant.id_user')
		->where('tuteurs_users.login', $username)
		->get();
		return $data;
	}

	private function getMySuggestions($username){
		$data =  DB::table('tuteurs_suggestions')
		->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_suggestions.id_user')
		->where('tuteurs_users.login', $username)
		->get();
		return $data;
	}

	private function getMyHelpSessions($username){
		$data = DB::table('tuteurs_suivi')
		->join('tuteurs_users', function ($join) {
			$join->on('tuteurs_suivi.id_user1', '=', 'tuteurs_users.user_id')
			->orOn('tuteurs_suivi.id_user2', '=', 'tuteurs_users.user_id');
		})
		->where('tuteurs_users.login', $username)
		->get();
		return $data;
	}

	private function getMyHelpSessionsOn($username){
		$data = DB::table('tuteurs_suivi')
		->join('tuteurs_users', function ($join) {
			$join->on('tuteurs_suivi.id_user1', '=', 'tuteurs_users.user_id')
			->orOn('tuteurs_suivi.id_user2', '=', 'tuteurs_users.user_id');
		})
		->where('tuteurs_users.login', $username)
		->where('tuteurs_suivi.resolu', 0)
		->get();
		return $data;
	}

	
}