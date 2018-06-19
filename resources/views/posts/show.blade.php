@extends('layouts.app')
    @section('content')
        <div class="row">
            <div class="col-md-12 bg-light" style="padding:10px;box-shadow:0px 0px 5px #EFEFEF;">
                <h2>
                    {{$post->title}}
                    @guest
                        {{-- nothing to show --}}
                    @else 
                        @if($post->user->id == auth()->user()->id)
                            <small class="float-right" style="font-size:10px;">
                                <a href="/posts/{{$post->id}}/edit">Edit</a> &nbsp;| &nbsp;
                                <div class="float-right">
                                    {!! Form::open(['action'=>['PostController@destroy', $post->id], 'method'=>'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::submit('Delete', ['class'=>'custom-del-but', 'onClick'=>'return DeleteWarning()']) }}
                                    {!! Form::close() !!}
                                </div>                        
                            </small>
                        @else 
                            {{-- nothing to show --}}
                        @endif
                    @endguest
                </h2>
                <h6>
                    <small>
                        Written by: <a href="/posts/user/{{$post->user->id}}">{{$post->user->name}}</a>
                    </small>
                </h6>
                <div class="desc">
                    {!! $post->body !!}
                </div>
                
                <div class="row">
                    <div class="col-md-1">
                        <a href="javascript:;" onClick="SubmitLike({{$post->id}})">
                                @guest
                                    <i class="far fa-heart"></i>                                            
                                @else                                            
                                    <span class="dynamic-change{{$post->id}}" total-likes-current="{{ $post->like->count() }}">                                     
                                        @php
                                            $liked_already = ''
                                        @endphp
                                        @foreach($post->like as $data)
                                            @if($data->user_id == auth()->user()->id)
                                                <i class="fas fa-heart"></i>
                                                @php
                                                    $liked_already = 1
                                                @endphp
                                            @else 
                                                {{-- nothing to display --}}                                                    
                                            @endif                                                
                                        @endforeach

                                        @if($liked_already==1)
                                            {{-- nothing to do --}}
                                        @else
                                            <i class="far fa-heart"></i>
                                        @endif                      
                                    </span>                                            
                                @endguest
                            </a> 
                            <span class="likes{{$post->id}}" post-id-data="{{$post->id}}">{{ $post->like->count() }}</span>
                    </div>
                    <div class="col-md-2">
                            <i class="far fa-comments"></i> {{$post->comment->count()}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 bg-light">
                        @if($post->comment->count() == 0)
                            <p>No comments yet</p>
                        @else
                            <p>Comments</p>                            
                            @foreach($post->comment as $comment_data)
                                <div class="row" style="border:1px solid #EFEFEF; padding: 10px; margin: 10px; box-shadow: 0 0 2px #99FF99;">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if($comment_data->user->image == 'defaultImage.jpg')
                                                    <i class="far fa-user float-left" style="width:20px; height:25px;"></i>
                                                @else
                                                    <img src="/storage/images/{{$comment_data->user->image}}" alt="" class="float-left" style="width:20px; height:25px;">
                                                @endif
                                                <small class="float-left" style="margin: 0 0 0 5px;">{{$comment_data->user->name}}</small>
                                            </div>
                                            <div class="col-md-2 offset-8">
                                                <small class="float-left" style="margin:0 0 0 30px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:10px;">{{$comment_data->created_at}}</small>
                                                {{-- Display the options --}}
                                                @guest
                                                    {{-- if user is not loggedin then nothing to display --}}
                                                @else
                                                    {{-- check if comment is belongs to logged in user or not --}}
                                                    @if($comment_data->user->id == auth()->user()->id)
                                                        <i class="fas fa-ellipsis-v float-right" class="edit-section dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer; font-size:10px; margin: 4px 0 0 0;"></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#editCommentModal">Edit</a>
                                                            {!! Form::open(['action'=>['CommentController@deleteComment'], 'method'=>'POST']) !!}
                                                                {{ Form::hidden('_method', 'DELETE') }}
                                                                {{ Form::hidden('post_id', $post->id) }}
                                                                {{ Form::hidden('comment_id', $comment_data->id) }}
                                                                {{ Form::submit('Delete', ['class'=>'dropdown-item', 'onClick'=>'return DeleteWarning()']) }}
                                                            {!! Form::close() !!}                                        
                                                        </div>
                                                        {{-- edit comment modal --}}
                                                        <div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="/comments/{{$comment_data->id}}">
                                                                    {{-- {!! Form::open(['action'=>['CommentController@update', $comment_data->id], 'method'=>'POST']) !!} --}}
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Comment</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @csrf                                                                            
                                                                            {{Form::textarea('message', $comment_data->body, ['id'=>'article-ckeditor', 'class'=>'form-control'])}}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                <button type="submit" name="submit" class="btn btn-primary">Update Comment</button>
                                                                                {{-- {{Form::submit('Update Comment', ['class'=>'btn btn-primary'])}} --}}
                                                                        </div>
                                                                    {{-- {!! Form::close() !!} --}}
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endguest
                                            </div>
                                        </div>
                                        <div class="row" style="margin: 10px 0 0 0;">
                                            <div class="col-md-12" style="padding:0;">
                                                {!! $comment_data->body !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 bg-light">                        
                        <h4>Leave a Comment</h4>
                        {!! Form::open(['action'=>'CommentController@store', 'method'=>'POST']) !!}
                            <div class="form-group">
                                {{Form::textarea('message', '', ['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder'=>'Type your comment here'])}}
                            </div>
                            <div class="form-group">
                                {{Form::hidden('post_id', $post->id)}}
                                @guest
                                    {{Form::button('Submit', ['class'=>'btn btn-primary', 'onClick'=>'loginFirst()'])}}
                                @else
                                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                                @endguest
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @section('script')
            <script>
                function DeleteWarning() {
                    return confirm('Are You Sure?');
                }

                function SubmitLike(post_id) {                    
                    var total_likes_current = $('.dynamic-change'+post_id).attr('total-likes-current');
                    $.ajax({
                        type: 'POST',
                        url: '{{URL::to("/likes")}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "post_id": post_id
                        },
                        success: function(data) {
                            console.log(data);
                            if(data=="loginFirst") {
                                window.location="/login";
                            } else {
                                $('.likes'+post_id).text(data.length);
                                if(data.length > total_likes_current) {
                                    //change the heart color to blue
                                    $('.dynamic-change'+post_id).html('<i class="fas fa-heart"></i>');
                                } else {
                                    // change the heart colot to white
                                    $('.dynamic-change'+post_id).html('<i class="far fa-heart"></i>');
                                }
                            }                                                        
                        }
                    });
                }

                function loginFirst() {
                    alert("Please login first to do comment on this post");                
                }
            </script>
        @endsection
    @endsection