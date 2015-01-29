<?php

class AuthController extends BaseController {

	//Signup GET method
	public function getSignup()
	{
		return View::make('qa.signup')
			->with('title','Sign Up!');
	}


}
