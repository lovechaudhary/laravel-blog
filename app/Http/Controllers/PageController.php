<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PageController extends Controller
{
    // Home page method
    public function home() {       
        // $data = array(
        //     'title' => 'Welcome to Tech Blog',
        //     'services' => [
        //         1=>
        //         [
        //             'post_title' => 'Programming in Javascript', 
        //             'author' => 'Love',
        //             'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim possimus sint iste repudiandae nisi inventore pariatur dignissimos quis illo doloremque porro corrupti, nam ullam id minima, voluptate vero consequuntur praesentium! Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim possimus sint iste repudiandae nisi inventore pariatur dignissimos quis illo doloremque porro corrupti, nam ullam id minima, voluptate vero consequuntur praesentium!',
        //             'created_time' => 'April 20, 2018',
        //             'comments' => 10,
        //             'likes' => 198
        //         ], 
        //         2=>
        //         [
        //             'post_title'=>'Programming in Angular', 
        //             'author'=>'Love',
        //             'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim possimus sint iste repudiandae nisi inventore pariatur dignissimos quis illo doloremque porro corrupti, nam ullam id minima, voluptate vero consequuntur praesentium! Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim possimus sint iste repudiandae nisi inventore pariatur dignissimos quis illo doloremque porro corrupti, nam ullam id minima, voluptate vero consequuntur praesentium!',
        //             'created_time' => 'April 20, 2018',
        //             'comments' => 10,
        //             'likes' => 198
        //         ]
        //     ]
        // );
        // $title = "Welcome to Tech Blog";
        $data = Post::orderBy('created_at', 'desc')->get();
        return view('pages.home')->with('data', $data );
    }

    // About page method
    public function about() {
        $title = "About Tech Blog";
        return view('.pages.about')->with('title', $title);
    }

    // Search page method
    public function search() {
        $title = "Search Particular Post";
        return view('pages.search')->with('title', $title);
    }

    // Find the post
    public function findPost(Request $request) {
        $data = Post::where('title', 'LIKE', '%'.$request->input('post_title').'%')->get();
        return $data;
    }

}
