<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //register user function 
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:18', 'confirmed']
        ]);

        //password modification
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        //storing value in database

        $user = User::create($incomingFields);
        //log user in before redirect
        auth()->login($user);
        return redirect('/')->with('success', 'Account has been created!!!');
    }

    //login user function 
    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => ['required'],
            'loginpassword' => ['required'],
        ]);
        //verify user details from database
        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            //
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Login Successful!');
        } else {
            //
            return redirect('/')->with('error', 'Invalid Login');
        }
    }
    //show when user is logged in
    public function showHomepage()
    {
        if (auth()->check()) {
            return view("homepage-feed");
        } else {
            return view("homepage");
        }
    }

    //logout session 
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You have logged out!');
    }

    //profile controller function
    public function profile(User $user)
    {
        // $userPosts = $user->posts()->get();
        // return $userPosts;
        // getting the user name and the post
        return view('profile-post', ['avatar' => $user->avatar, 'username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
    }

    public function manageAvatar()
    {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required | image | max:3000',
        ]);

        $user = auth()->user();

        $filename = $user->id . ' - ' . uniqid() . 'jpg';

        //file storage on hard disk
        $img = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/' . $filename, $img);

        //old profile image
        $oldAvatar = $user->avatar;

        //storing the image data to the database
        $user -> avatar = $filename;
        $user -> save();

        //set new profile image
        if ($oldAvatar != "/fallback-avatar.jpg") {
            //the str_replace() function is used to replace characters 
            Storage::delete(str_replace("/storage/", "public", $oldAvatar));
        }

        return back()->with('success', 'Successfully uploaded another profile image.');
    }
}
