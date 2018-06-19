@extends('layouts.app')
    @section('content')
        <h1>{{$title}}</h1>
        <div class="row search-container">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" id="search" class="form-control" placeholder="Enter your search">
                </div>
                <div class="search-box">
                    <i>Your Result display here....</i>
                </div>
            </div>
        </div>
        @section('script')
            <script>
                $(document).ready(function(){
                    $('#search').on('keyup', function(e) {
                        var post_title = $(this).val();
                        var url = '{{URL::to("/posts/")}}';
                        if($(this).val() == '') {
                            $('.search-box').html('<i>Your Result display here....</i>');
                        } else {                            
                            $.ajax({
                                type: 'POST',
                                url: '{{URL::to("/posts/search")}}',
                                data: {
                                    "_token" : "{{csrf_token()}}",
                                    "post_title": post_title
                                },
                                success: function(data) {                                    
                                    $.each(data, function(key, value){
                                        $('.search-box').html('<a href="'+url+'/'+value.id+'">'+value.title+'</a>');                                       
                                    });                                    
                                }
                            })
                        }
                    });
                });
            </script>
        @endsection
    @endsection