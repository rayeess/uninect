<?php

class QuestionsController extends \BaseController {

	/**
      * A new question asking form
    **/
    public function getNew()
    {	
    	return View::make('qa.ask')
       		->with('title','New Question');
    }

    /**
      * Post method to process the form
    **/
    public function postNew()
    {
    	//first, let's validate the form
        $validation = Validator::make(Input::all(), Question::$add_rules);
        
        if($validation->passes())
        {
        	//First, let's create the question
           	$create = Question::create(array(
           		'userID' => Sentry::getUser()->id,
            	'title' => Input::get('title'),
            	'question' => Input::get('question')
            	));

           	//We get the insert id of the question
           	$insert_id = $create->id;
           	
           	//Now, we need to re-find the question to "attach" the tag to the question
           	$question = Question::find($insert_id);
           	
           	//Now, we should check if tags column is filled, and split the string and add a new tag and a relation
           	if(Str::length(Input::get('tags')))
           	{
           		//let's explode all tags from the comma
            	$tags_array = explode(',', Input::get('tags'));
            	//if there are any tags, we will check if they are new, if so, we will add them to database
				//After checking the tags, we will have to "attach" tag(s) to the new question
				if(count($tags_array))
				{
					foreach ($tags_array as $tag)
					{
						//first, let's trim and get rid of the extra space bars between commas
    						//(tag1, tag2, vs tag1,tag2)
    					$tag = trim($tag);
    					//We should double check its length, because the user may have just typed "tag1,,tag2" (two or more commas) accidentally
    					//We check the slugged version of the tag, because tag string may only be meaningless character(s), like "tag1,+++//,tag2"
    					if(Str::length(Str::slug($tag)))
    					{
    						//the URL-Friendly version of the tag
    						$tag_friendly = Str::slug($tag);
      						//Now let's check if there is a tag with the url friendly version of the provided tag already in our database:
      						$tag_check = Tag::where('tagFriendly',$tag_friendly);
							//if the tag is a new tag, then we will create a new one
      						if($tag_check->count() == 0)
      						{
      							$tag_info = Tag::create(array(
          							'tag' => $tag,
          							'tagFriendly' => $tag_friendly
          							));
          						//If the tag is not new, this means There was a tag previously added on the same name to another question previously
        						//We still need to get that tag's info from our database
        						} else {
        						$tag_info = $tag_check->first();
        					}
        				}

        				//Now the attaching the current tag to the question
        				$question->tags()->attach($tag_info->id);
        			}
        		}
        	}

        	//lastly, we should return the user to the asking page with a permalink of the question
        	return Redirect::route('ask')
            	->with('success','Your question has been created successfully! '.HTML::linkRoute('question_details', 'Click here to see your question',array(
             		'id'=>$insert_id,'title'=>Str::slug($question->title))));
        } else {
        	return Redirect::route('ask')
            	->withInput()
            	->with('error',$validation->errors()->first());
        }
    }
}