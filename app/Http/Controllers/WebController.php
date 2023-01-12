<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    //controller method goes here

    public function HomePage()
    {
        //imagine we loaded data from the database
        $ourName = 'Clement';
        $animals = array(
            'meowsalot',
            'barksalot',
            'shitalot',
        );
        // return view('welcome');
        return view('homepage', [ 'allanimals' => $animals, 'name' => $ourName, 'catName' => "meosalot" ]);
    }

    public function About()
    {
        return view('single-post');
    }
}
