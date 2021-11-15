<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function ShowMain(){
        return Inertia::render('movie/mainpage');
    }
}
