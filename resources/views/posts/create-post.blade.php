@extends('layouts.app')
    @section('content')
        <h1>{{$title}}</h1>
        {!! Form::open(['action' => 'PostController@store', 'method'=>'POST']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class'=>'form-control', 'placeholder'=>'Enter Post Title'])}}
            </div>
            <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', '', ['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder'=>'Enter your post description'])}}
            </div>
            <div class="form-group">
                {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            </div>
        {!! Form::close() !!}        
    @endsection