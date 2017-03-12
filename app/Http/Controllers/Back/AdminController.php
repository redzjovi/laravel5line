<?php
namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
	public function index()
	{
		if (Auth::check()) {
			return redirect('back/dashboard');
		}

		return view('back.admin.login');
	}

	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), User::$rules['login']);

		if ($validator->fails()) {
			$response = ['status' => '0', 'errors' => $validator->errors()];
		} else {
			$response = ['status' => '1', 'url' => Url('back/dashboard')];

			$auth = array(
	   			'email' => $request->get('email'),
	   			'password' => $request->get('password')
   			);
   			Auth::attempt($auth);
		}

		return $response;
	}

	public function logout()
	{
		Auth::logout();
		return redirect('back/admin');
	}
}