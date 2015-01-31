<?php

class Question extends Eloquent {

	protected $fillable = array('title', 'userID', 'question', 'viewed', 'answered', 'votes');

	public static $add_rules = array(
        'title' => 'required|min:2',
        'question' => 'required|min:10'
    	);

	public function users() {
		return $this->belongsTo('User','userID');
	}

	public function tags() {
		return $this->belongsToMany('Tag','question_tags')->withTimestamps();
    }

}