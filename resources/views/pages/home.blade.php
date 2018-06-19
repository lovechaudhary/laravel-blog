@extends('layouts.app')
    @section('content')
        {{-- <h1>{{$title}}</h1> --}}
        <ul class="list-group">
            @if(count($data) > 0)
                @foreach($data as $post)
                    <li class="list-group-item" style="margin:10px 0 10px 0;">
                        <div class="row">
                            <div class="col-md-10">
                                <h4>
                                    <a href="/posts/{{$post->id}}">{{$post->title}}</a>
                                </h4>
                            </div>
                            <div class="col-md-2" style="font-size:10px;font-family:Verdana, Geneva, Tahoma, sans-serif;">
                                {{$post->created_at}}
                                @guest
                                    {{-- nothing to display to not loggedin users --}}
                                @else
                                    @if($post->user->id == auth()->user()->id)
                                        <div class="float-right dropdown-show">
                                            <i class="fas fa-ellipsis-v" class="edit-section dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer"></i>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="/posts/{{$post->id}}/edit">Edit</a>
                                                {!! Form::open(['action'=>['PostController@destroy', $post->id], 'method'=>'POST']) !!}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                    {{ Form::submit('Delete', ['class'=>'dropdown-item', 'onClick'=>'return DeleteWarning()']) }}
                                                {!! Form::close() !!}                                        
                                            </div>
                                        </div>
                                    @else
                                        {{-- nothing to display for not logged in users --}}
                                    @endif
                                @endguest
                            </div>
                        </div>                    
                        <h6>
                            <small>
                                Written By: <a href="/posts/user/{{$post->user->id}}">{{$post->user->name}}</a>
                            </small>
                        </h6>                    
                        <div class="desc">
                            @if(strlen($post->body) > 400)
                                {!! substr($post->body, 0, 400) !!}
                                &nbsp;&nbsp;<small><a href="/posts/{{$post->id}}">Read more....</a></small>
                            @else 
                                {!! $post->body !!}
                            @endif
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
                                    <a href="/posts/{{$post->id}}"><i class="far fa-comments"></i></a> {{$post->comment->count()}}
                            </div>
                        </div>
                    </li>
                @endforeach               
            @else
                <li class="list-group-item">No Post yet.</li>     
            @endif            
        </ul>  
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
            </script>      
        @endsection
    @endsection