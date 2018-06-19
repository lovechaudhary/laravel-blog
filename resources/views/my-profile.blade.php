@extends('layouts.app')
    @section('content')        
        <h1>My Profile</h1>
        <div class="row">
            <div class="col-md-2">
                @if($user->image == 'defaultImage.jpg')
                    <i class="far fa-user" style="width:150px;height:150px;border:5px solid #EFEFEF;padding:10px;"></i>
                @else
                    <img src="/storage/images/{{$user->image}}" alt="profile picture" style="width:80%; height:80%;">
                @endif                
                {{-- Change picture modal starts --}}
                <!-- Button trigger modal -->
                    <a href="javascript:;" style="margin: 0 0 0 15%;" data-toggle="modal" data-target="#changePictureModal">Change Picture</a>                    
                    
                    <!-- Modal -->
                    <div class="modal fade" id="changePictureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="POST" action="/myProfile" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <input type="file" name="image" id="image" onChange="readImageURL(this)"/>
                                        <div>
                                            <img src="#" id="showPreview" style="margin: 10px 0 0 0;display:none;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Update Pic</button>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                {{-- Change picture modal edns --}}
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-10">
                        <i>Name: {{$user->name}}</i>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:;" data-toggle="modal" data-target="#editProfile">Edit profile</a>
                        {{-- edit profile modal starts --}}
                        <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/myProfileData" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="submit" class="btn btn-primary">Update Profile Information</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- edit profile modal ends --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <i>Email: {{$user->email}}</i>
                    </div>
                </div>                              
            </div>
        </div>        
        <script>
            function readImageURL(input) {
                if(input.files && input.files[0]) {
                    var reader =  new FileReader();

                    reader.onload = function(event) {                        
                        $('#showPreview')
                            .attr('src', event.target.result)
                            .width(150)
                            .height(150);
                        $('#showPreview').show();
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endsection