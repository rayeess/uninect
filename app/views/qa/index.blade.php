@extends('template_masterpage')

@section('content')
	<h1>{{$title}}</h1>
    @if(count($questions))
    	@foreach($questions as $question)
        <?php
        //Question's asker and tags info
        $asker = $question->users;
        $tags = $question->tags;
        ?>
        
        <div class="qwrap questions">
	        {{-- Guests cannot see the vote arrows --}}
	        @if(Sentry::check())
	        	<div class="arrowbox">
	        		{{HTML::linkRoute('vote','',array('up',$question->id),array('class'=>'like','title'=>'Upvote'))}}
	               	{{HTML::linkRoute('vote','',array('down',$question->id),array('class'=>'dislike','title'=>'Downvote'))}}
	            </div>
	        @endif

	        {{-- class will differ on the situation --}}
	        @if($question->votes > 0)
	        <div class="cntbox cntgreen">
	        @elseif($question->votes == 0)
	        <div class="cntbox">
	        @else
	        <div class="cntbox cntred">
	        @endif
		        <div class="cntcount">{{$question->votes}}</div>
		        <div class="cnttext">vote</div>
	        </div>
	        
	        {{--Answer section will be filled later in this chapter--}}
	        <div class="cntbox">
	        	<div class="cntcount">0</div>
	        	<div class="cnttext">answer</div>
	        </div>
	        <div class="qtext">
	        	<div class="qhead">
	            {{HTML::linkRoute('question_details',$question->title,array($question->id,Str::slug($question->title)))}}
	            </div>
	            <div class="qinfo">Asked by <a href="#">{{$asker->first_name.' '.$asker->last_name}}</a> around {{date('m/d/Y H:i:s',strtotime($question->created_at))}}</div>
	            @if($tags!=null)
	            <ul class="qtagul">
	                @foreach($tags as $tag)
	                <li>{{HTML::linkRoute('tagged',$tag->tag,$tag->tagFriendly)}}</li>
	                @endforeach
	            </ul>
	            @endif
	      	</div>
    	</div>
    	@endforeach
  		
  		{{-- and lastly, the pagination --}}
		{{$questions->links()}}
	@else
  	No questions found. {{HTML::linkRoute('ask','Ask a question?')}}
	@endif
@stop