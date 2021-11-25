<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $movie = Movie::find($room_id);
        return $movie;
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
    public function PostComment(Request $request,$room_id){
        $comment = new Comment;
        $comment -> user_id = Auth::id();
        $comment -> movie_id = $room_id;
        $comment -> comment = $request ->comment_content;
        $comment -> rating = $request ->comment_rating;
        $comment -> save();
    }
    public function PostShowRoom($movie_title){
        $movie = DB::table('movies')->where('title',"=",$movie_title)->first();
        return $movie;
    }
    public function MainShowMovie(){
        $movies = DB::table('movies')->orderBy('updated_at','desc')->take(10)->get();
        return $movies;
    }
}
