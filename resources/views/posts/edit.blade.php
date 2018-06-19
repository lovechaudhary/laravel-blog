@extends('layouts.app');
    @section('content')
        <div class="row">
            <div class="col-md-12">
            {!! Form::open(['action' => ['PostController@update', $post->id], 'method'=>'POST']) !!}
                    <div class="form-group">
                        {{Form::label('title', 'Title')}}
                        {{Form::text('title', $post->title, ['class'=>'form-control', 'placeholder'=>'Enter Post Title'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('body', 'Body')}}
                        {{Form::textarea('body', $post->body, ['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder'=>'Enter your post description'])}}
                    </div>
                    <div class="form-group">
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endsection