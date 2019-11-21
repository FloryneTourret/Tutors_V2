<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function index($category = null){
		if(!session()->exists('username'))
			return redirect()->route('login');
		else
		{
			$categories = DB::table('tuteurs_categories')->get('nom');
			if (isset($category))
			{
				$posts = DB::table('tuteurs_blog')
				->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_blog.id_user')
				->join('tuteurs_blog_categorie', 'tuteurs_blog_categorie.id_post', '=', 'tuteurs_blog.post_id')
				->join('tuteurs_categories', 'tuteurs_categories.categorie_id', '=', 'tuteurs_blog_categorie.id_categorie')
				->where('tuteurs_categories.nom', $category)
				->paginate(5);
				$category = DB::table('tuteurs_categories')
				->where('nom', $category)
				->first();
				if ($category)
					return view('home', compact('posts'), ['categories' => $categories]);
				else
					return view('home', ['error' => 'Cette page n\'existe pas']);
			}
			$posts = DB::table('tuteurs_blog')
			->join('tuteurs_users', 'tuteurs_users.user_id', '=', 'tuteurs_blog.id_user')
			->paginate(5);

			return view('home', compact('posts'), ['categories' => $categories]);
		}
	}
}