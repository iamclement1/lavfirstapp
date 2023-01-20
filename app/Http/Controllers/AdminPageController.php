<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    //
    public function isAdmin() {
        return "only admin should be allowed to access this page.";
    }
}
