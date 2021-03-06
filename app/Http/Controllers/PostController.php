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
        $comment -> user_name = Auth::user()->name;
        // $comment -> user_imagePath = Auth::user()->profile_photo_path;
        $image =Auth::user()->profile_photo_path;
        if(!$image)
            $comment->user_imagePath="../images/null.jpg";
        else
            $comment -> user_imagePath = '/storage/'.$image;

        $comment -> movie_id = $room_id;
        $comment -> comment = $request ->comment_content;
        $comment -> rating = $request ->comment_rating;
        $comment -> save();

        $movie = Movie::find($room_id);
        $movieRating = $movie -> totalRating;
        $movieRating += $request->comment_rating;
        $movieCount = $movie -> ratingCount;
        $movieCount += 1;
        $movie -> totalRating = $movieRating;
        $movie -> ratingCount = $movieCount;
        $movie->save();

    }
    public function PostShowRoom($movie_title){
        $movie = DB::table('movies')->where('title',"=",$movie_title)->first();
        return $movie;
    }
    public function MainShowMovie(){
        $movies = DB::table('movies')->orderBy('updated_at','desc')->take(10)->get();
        return $movies;
    }
    public function CommentInfo($room_id){
        $comments = DB::table('comments')->where("movie_id","=",$room_id)->latest()->paginate(6);
        return $comments;
    }
    public function ShowComments()
    {
        $comments = DB::table('comments')->orderBy('created_at','desc')->take(10)->get();
        $len = count($comments);
        for($i=0;$i<$len;$i++){
                $movie_info = DB::table('movies')->where("id","=",$comments[$i]->movie_id)->get();
                $comments[$i] -> movie_info = $movie_info;

        }
        return $comments;


    }
    public function CheckComment($movie_id){
        $myId = Auth::id();
        $comment = DB::table('comments')->where([
            ["user_id","=",$myId],
            ["movie_id","=",$movie_id]
        ])->get();

        return $comment;
    }
    public function EditComment(Request $request,$comment_id){
        $comment = Comment::find($comment_id);
        $original =$comment->rating;
        $comment->comment = $request -> comment;
        $comment->rating = $request -> rating ;
        $comment->save();

        $movie = Movie::find($request -> room_id);
        $movieRating = $movie -> totalRating;
        $movieRating -= $original;
        $movieRating += $request->rating;
        $movie -> totalRating = $movieRating;
        $movie->save();

        return $comment;
    }
    public function DeleteComment($comment_id){
        $comment = Comment::find($comment_id);
        $rating = $comment -> rating;
        $movie = Movie::find($comment -> movie_id);
        $movieRating = $movie -> totalRating;
        $movieRating -= $rating;
        $movie->totalRating=$movieRating;
        $movie -> ratingCount -= 1;

        $movie->save();

        $comment->delete();
    }
}
