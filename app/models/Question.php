<?php

class Question extends Eloquent {

	protected $fillable = array('title', 'userID', 'question', 'viewed', 'answered', 'votes');

	public function users() {
		return $this->belongsTo('User','userID');
	}

	public function tags() {
		return $this->belongsToMany('Tag','question_tags')->withTimestamps();
    }

}