<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PostController extends Controller
{
    public function ShowMain(){
        return Inertia::render('movie/mainpage');
    }
    public function ShowSearch(){
        return Inertia::render('movie/searchpage');
    }
    public function SearchNow($searchword){
        return Inertia::render('movie/searchpage')->with("data",$searchword);
    }
    public function ShowRoom($room_id){
        return Inertia::render('movie/roompage')->with("data",$room_id);

    }
    public function RoomInfo($room_id){

    }
    public function MakeRoom(Request $request){
        $movie = new Movie;
        $movie -> title = $request -> title;
        $movie -> subtitle = $request -> subtitle;
        $movie -> pubDate = $request->pubDate;
        $movie -> actor = $request ->actor;
        $movie -> director = $request->director;
        $movie -> image_path = $request -> image;
        $movie -> userRating = $request -> userRating;
        $movie -> save();

        return $movie -> id;
    }
    public function MainShowMovie(){
        $movies = DB::table('movies')->orderBy('updated_at','desc')->take(10)->get();
        return $movies;
    }
}
