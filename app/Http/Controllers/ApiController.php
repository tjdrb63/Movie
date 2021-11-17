<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    // public function CheckRoom(Request $request){

    //     $movies = $request-> movies;

    //     return $movies;
    // }
    public function NaverApiCall($searchword){
        $client_id = "SsgRiK_qaB1ml14S5951"; //발급받은 client id & secret key
        $client_secret = "s7mfRniC_a";
        $encText = urlencode($searchword); //검색할 Text를 url인코딩
        $url = "https://openapi.naver.com/v1/search/movie.json?query=".$encText."&display=100";
        $is_post = false;
        $ch = curl_init(); //세션 초기화

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = "X-Naver-Client-Id: ".$client_id;
        $headers[] = "X-Naver-Client-Secret: ".$client_secret;

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $json = json_decode($response);
        curl_close ($ch);
        if($status_code == 200) { //정상
            $arr = [];
            $count = $json->display;
            for($i=0;$i<$count;$i++){
                // API html 및 특수문자 데이터 처리

                $change_image = str_replace("mit110","mit500",$json->items[$i]->image);
                $json->items[$i]->image = $change_image;
                $change_title = str_replace(["<b>","</b>"],"",$json->items[$i]->title);
                $json->items[$i]->title = $change_title;
                $change_subtitle = str_replace("&amp;","&",$json->items[$i]->subtitle);
                $json->items[$i]->subtitle = $change_subtitle;
                //이미 있는 방인지 검사
                $movies = DB::table('movies')->where('title',$json->items[$i]->title)->first();
                if($movies)
                    $json->items[$i]->isOn=true;
                else
                    $json->items[$i]->isOn=false;



            }
            //     $movie  = new Movie;
            //     $data = $json->items[$i];
            //     $movie -> title = $data -> title;
            //     $movie -> subtitle = $data -> subtitle;
            //     $movie -> pubDate = $data ->pubDate;
            //     $movie -> actor = $data ->actor;
            //     $movie -> director = $data->director;
            //     $movie -> image_path = $change_image;
            //     $movie -> userRating = $data -> userRating;
            //     $movie -> save();
            // }
            // return $json;
            return $json;
        }
        else {

        }
    }
}
