<?php

class AnswersController extends \BaseController {

	/**
	 * Adds a reply to the questions
	**/
  public function postReply($id,$title)
  {
  	//First, let's check if the question id is valid
    $question = Question::find($id);
    //if question is found, we keep on processing
    if($question)
    {
    	//Now let's run the form validation
		  $validation = Validator::make(Input::all(), Answer::$add_rules);

		  if($validation->passes())
		  {
  			//Now let's create the answer
  			Answer::create(array(
  				'questionID' => $question->id,
          'userID' => Sentry::getUser()->id,
  			  'answer' => Input::get('answer')
  			   ));

  			//Finally, we redirect the user back to the question page with a success message
        return Redirect::route('question_details', array($id,$title))
          ->with('success','Answer submitted successfully!');
     	} else {
       	return Redirect::route('question_details', array($id,$title))
          ->withInput()
         	->with('error',$validation->errors()->first());
      }
   	} else {
   		return Redirect::route('index')
        	->with('error','Question not found');
    }
	}

  /**
   * Vote AJAX Request
  **/
  public function getVote($direction, $id)
  {
    //request has to be AJAX Request
    if(Request::ajax())
    {
      $answer = Answer::find($id);
      //if the answer id is valid
      if($answer)
      {
        //new vote count
        if($direction == 'up')
        {
          $newVote = $answer->votes+1;
        } else {
          $newVote = $answer->votes-1;
        }
        //now the update
        $update = $answer->update(array('votes' => $newVote));
        //we return the new number
        return $newVote;
      } else {
        //answer not found
        Response::make("FAIL", 400);
      }
    } else {
      return Redirect::route('index');
    }
  }
}
