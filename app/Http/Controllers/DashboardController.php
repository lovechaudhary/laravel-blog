<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $user_data = User::find($id);
        return view('dashboard')->with('user', $user_data);
    }

    public function myProfile() {
        $user = auth()->user();
        return view('my-profile')->with('user', $user);
    }

    public function updateProfilePic(Request $request) {
        $this->validate($request, [
            'image' => 'required|image|nullable|max:1999'
        ]);
        // Handle File Update
        if($request->hasFile('image')) {
            $filenameOrignal = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameOrignal, PATHINFO_FILENAME);
            $extenstion = $request->file('image')->getClientOriginalName();
            $filenameToStore = $filename.'_'.time().'.'.$extenstion;            
            $path = $request->file('image')->storeAs('public/images', $filenameToStore);            
        }
        
        $id = auth()->user()->id;
        $user = User::find($id);
        if($request->hasFile('image')) {
            Storage::delete('public/images/'.$user->image);
            $user->image = $filenameToStore;
        }        

        $user->save();
        return redirect('/myProfile')->with('success', 'Image Updated');
    }

    public function myProfileData(Request $request) {
        $id = auth()->user()->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ]);
        
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect('/myProfile')->with('success', 'Profile Updated');
    }

}
