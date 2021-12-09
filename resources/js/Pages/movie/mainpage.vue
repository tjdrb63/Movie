<template>
    <div id="page-wrapper">
        <app-layout>
        <!-- Header -->
        <header id="header">
            <div class="logo container">
                <div>
                    <h1><a href="/main" id="logo">Main Page</a></h1>
                    <p></p>
                </div>
            </div>
        </header>

            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li class="current"><a href="/main">메인페이지</a></li>
                    <li><a href="/search">영화 검색</a></li>
                    <li><a v-if="user" :href="route('profile.show')">내 정보</a></li>
                    <li><a v-if="!user" :href="route('login')">로그인</a></li>
                    <li><a v-if="!user" :href="route('register')">회원가입</a></li>

                </ul>
            </nav>

            <!-- Banner -->
            <section id="banner">
                <div class="content">
                    <h2>Movie Review</h2>
                    <p>실제 관람객에 의한 영화 리뷰</p>
                </div>
            </section>

            <!-- Main -->
            <section id="main">
                <div class="container">
                    <div class="row gtr-200">
                        <div class="col-12">
                            <!-- Highlight -->
                        </div>
                        <div class="col-12">
                            <!-- Features -->
                            <section class="box features">
                                <h2 class="major"><span>최근 생성된 영화</span></h2>
                                <div>
                                    <carousel :items-to-show="3.5" :autoplay="3000" :wrapAround="true">
                                        <slide v-for="movie in movies" :key="movie">
                                            <div class="w-100">
                                                <div @click="clickPoster(movie.title)" class="m-2 shadow-lg border-gray-800 bg-gray-200 relative hover:bg-gray-100">
                                                    <img :src="`${movie.image_path}`" alt="" />
                                                    <div class="badge absolute top-0 right-0 bg-red-500 m-1 text-gray-200 p-1 px-2 text-xs font-bold rounded">New</div>
                                                    <div class="absolute m-1 flex top-0 text-xs  font-semibold text-gray-700 ">
                                                        <span class="rounded text-white bg-green-300 mr-1 p-1 font-bold">N {{movie.userRating}}</span>
                                                    </div>
                                                    <div class="py-4 ">
                                                        <h4  class="text-xl font-bold block"><h5>{{movie.title}}</h5></h4>
                                                        <h5 class="text-gray-500">{{movie.subtitle}}</h5>
                                                        <div class="flex justify-center">
                                                            <div v-for="star in stars" :key="star">
                                                                <h4 v-if="(movie.totalRating/movie.ratingCount).toFixed(1) >= star" class="fas fa-star fa-lg text-yellow-500 mr-1"></h4>
                                                                <h4 v-if="(movie.totalRating/movie.ratingCount).toFixed(1) < star" class="far fa-star fa-lg text-yellow-500 mr-1"></h4>
                                                            </div>
                                                            <h4 v-if="movie.totalRating == null"> 리뷰없음</h4>
                                                            <!-- <h2 v-if="movie.totalRating" class="absolute font-bold">{{(movie.totalRating/movie.ratingCount).toFixed(1)}}</h2> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </slide>
                                        <template $addons>
                                            <navigation />
                                            <pagination />
                                        </template>
                                    </carousel>

                                    <div class="col-12">
                                        <ul class="actions">
                                            <li><a href="/search" class="button large">영화 검색 하러가기</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-12">
                            <section class="box blog">
                                <h2 class="major"><span>최근 리뷰 </span></h2>



                                <!-- 클릭된 창 -->
                                <div v-for="info in clickedComment.movie_info" :key="info" class="flex flex-col justify-center mb-8">
                                    <div class="w-full relative flex flex-col md:flex-row md:space-x-5 space-y-3 md:space-y-0 rounded-xl shadow-lg p-3 max-w-xs md:max-w-3xl mx-auto border border-white bg-gray-100">
                                        <div  class="w-full md:w-1/3 bg-gray-100 grid place-items-center">
                                            <img :src="`${info.image_path}`" alt="tailwind logo" class="rounded-xl" />
                                        </div>
                                        <div class="w-full md:w-2/3 bg-gray-100 flex flex-col space-y-2 p-3">
                                            <!-- 제목/내용 -->
                                            <div class="h-4/5">
                                                <h3 class="font-black text-gray-800 text-3xl">{{info.title}}</h3>
                                                <h4 class="font-black text-gray-500 text-md">{{info.subtitle}}</h4>
                                                <div class="flex">
                                                    <img class="rounded-full w-8 h-8" :src="`${clickedComment.user_imagePath}`"  alt="이미지">
                                                    <h4 class="text-md mt-1 ml-1 text-gray-500 ">{{clickedComment.user_name}}</h4>
                                                    <div class="flex ml-2">
                                                        <div v-for="star in stars" :key="star">
                                                            <li v-if="clickedComment.rating >= star" class="fas fa-star fa-sm text-yellow-500 mr-1"></li>
                                                            <li v-if="clickedComment.rating < star" class="far fa-star fa-sm text-yellow-500 mr-1"></li>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="mt-1 text-md text-gray-500 text-base">{{clickedComment.comment}}</p>
                                            </div>
                                            <!-- 날짜및 정보 -->
                                            <div class="h-1/5 pt-8 flex justify-between item-center">
                                                    <p class="text-gray-500 font-medium hidden md:block">{{clickedComment.updated_at}}</p>
                                                <div class="flex items-center">
                                                    <h4 class="text-gray-600 font-bold text-sm ml-1">
                                                    {{ (info.totalRating/info.ratingCount).toFixed(2) }}
                                                    <span class="text-gray-500 font-normal">({{ info.ratingCount}} reviews)</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <ul class="actions">
                                            <a v-bind:href="`/room/${info.id}`" class="w-96 button large">해당 영화로 이동하기</a>
                                        </ul>
                                    </div>

                                </div>


                                <carousel :items-to-show="4" :autoplay="3000" :wrapAround="true">
                                    <slide v-for="comment in comments" :key="comment">
                                        <div @click="changeComment(comment)" class="w-full m-2">
                                            <div class="w-full rounded-lg bg-white p-5 shadow text-gray-800">
                                                <div class="w-full">
                                                        <h4 class="font-bold text-md">{{comment.movie_info[0].title}}</h4>
                                                    <div class="flex mb-2 text-center ml-20">
                                                        <div v-for="star in stars" :key="star">
                                                            <h4 v-if="comment.rating >= star" class="fas fa-star fa-sm text-yellow-500 mr-1"></h4>
                                                            <h4 v-if="comment.rating < star" class="far fa-star fa-sm text-yellow-500 mr-1"></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full h-8 mb-4 truncate">
                                                    <p class="text-sm">{{comment.comment}}</p>
                                                </div>
                                                <div class="w-full">
                                                    <span class="text-xs text-gray-500 text-right">{{comment.updated_at}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </slide>
                                    <template $addons>
                                        <Navigation />
                                        <Pagination />
                                    </template>
                                </carousel>

                            </section>

                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer id="footer">
                <div class="container">
                    <div class="row gtr-200">
                        <div class="col-12">

                            <!-- About -->
                            <section>
                                <h2 class="major"><span>What's this about?</span></h2>
                                <p>
                                    This is <strong>TXT</strong>, yet another free responsive site template designed by
                                    <a href="http://twitter.com/ajlkn">AJ</a> for <a href="http://html5up.net">HTML5 UP</a>.
                                    It's released under the
                                    <a href="http://html5up.net/license/">Creative Commons Attribution</a> license so feel
                                    free to use it for
                                    whatever you're working on (personal or commercial), just be sure to give us credit for
                                    the design.
                                    That's basically it
                                </p>
                            </section>

                        </div>
                    </div>
                    <!-- Copyright -->
                    <div id="copyright">
                        <ul class="menu">
                            <li>&copy; Untitled. All rights reserved</li>
                            <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                        </ul>
                    </div>

                </div>
            </footer>
        </app-layout>
    </div>
</template>

<style>
    @import './css/main.css';
</style>

<script>

import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import axios from 'axios'
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
  components: {
      AppLayout,
       Carousel,
        Slide,
        Pagination,
        Navigation,
   },
   props:['user']
    ,
    data(){
        return{
            movies:[],
            comments:[],
            search:'',
            calRating:0,
            nowTime:"00:00:00",
            stars:[1,2,3,4,5],
            clickedComment:[],
        }
    },
    methods:{
        showComment(){
            axios.post('/show/comments')
            .then(res=>{
                console.log(res.data)
                this.comments = res.data
                this.clickedComment=this.comments[0]
            })
        },
        changeComment($res){
            this.clickedComment=$res
        },
        clickPoster($movie_title){
            console.log($movie_title)
            axios.post('/show/room/'+$movie_title)
            .then(res=>{
                console.log(res.data)
                window.location.href="/room/"+res.data.id
            })
        },
        MainShowMovie(){
            console.log("영화 리스트 요청함")
            axios.post("main/show/movie")
            .then(res =>{
                this.movies = res.data;

            })
        },
        NaverApiCall(){
            console.log("api 요청보냄");
            axios.get("main/search/"+this.search)
            .then(res =>{
                console.log(res);
            })
        },
        TextApiCall(){
            console.log("Text api 요청보냄")
            axios.post("api/call/text")
            .then(res=>{
                console.log(res);
            })
        }
    },
    mounted(){
        this.MainShowMovie()
        this.showComment()
        // this.TextApiCall()
    },
    logout() {
        console.log("로그아웃 호출")
        this.$inertia.post(route('logout'));
    },





}
</script>
