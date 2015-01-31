<?php

class MainController extends BaseController {

	public function getIndex()
	{
		return View::make('qa.index')
			->with('title','Hot Questions!')
       		->with('questions',Question::with('users','tags')->orderBy('id','desc')->paginate(2));
	}


}
