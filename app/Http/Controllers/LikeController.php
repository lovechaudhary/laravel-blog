<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Auth;
use DB;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post_id = $request->post_id;
        if(Auth::guest()) {
            return "loginFirst";
        }
        $user_id = auth()->user()->id;
        // check if this user already liked this post
            $liked_post = Like::where('post_id', $post_id)
                            ->Where('user_id', $user_id)
                            ->get();            
            if($liked_post->count() > 0) {
                //already liked this post bu current user
                // now delete this like from record
                $like = Like::where('post_id', $post_id)
                            ->where('user_id', $user_id)
                            ->delete();
                // $like->delete();                            
            } else {
                //not liked yet this post by this user
                // now save this like into record
                $like = new Like();
                $like->user_id = auth()->user()->id;
                $like->post_id = $post_id;
                $like->save();                
            }
            

        // Count total likes according to this post
        $current_post_likes = Like::where('post_id', $post_id)->get();
        return $current_post_likes;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
