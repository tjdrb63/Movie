<template>
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header">
            <div class="logo container">
                <div>
                    <h1><a href="index.html" id="logo">Main Page</a></h1>
                    <p></p>
                </div>
            </div>
        </header>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li class="current"><a href="index.html">메인페이지</a></li>
                <li><a href="search">영화 검색</a></li>
                <li><a href="">내 정보</a></li>
            </ul>
        </nav>
        <!-- Banner -->
        <section id="banner">
            <div class="content">
                <h2>Movie Review</h2>
                <p>실제 관람객에 의한 영화 리뷰</p>
                <!-- <a href="#main" class="button scrolly">Alright let's go</a> -->
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
                                            <div class="m-2 shadow-lg border-gray-800 bg-gray-200 relative">
                                                <img :src="`${movie.image_path}`" alt="" />
                                                <div class="badge absolute top-0 right-0 bg-red-500 m-1 text-gray-200 p-1 px-2 text-xs font-bold rounded">New</div>
                                                <div class="absolute m-1 flex top-0 text-xs  font-semibold text-gray-700 ">
                                                    <span class="rounded text-white bg-green-300 mr-1 p-1 font-bold">N {{movie.userRating}}</span>
                                                </div>
                                                <div class="py-4">
                                                    <a @click="clickPoster(movie.title)" class="text-lg font-bold block"><h5>{{movie.title}}</h5></a>
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
                        <!-- Blog -->
                        <section class="box blog">
                            <h2 class="major"><span>최근 리뷰 </span></h2>
                            <div>
                                <div class="row">
                                    <div class="col-9 col-12-medium">
                                        <div class="content">
                                            <!-- Featured Post -->
                                            <article class="box post">
                                                <header v-for="info in clickedComment.movie_info" :key="info">
                                                    <h3 class="text-gray-600">{{info.title}}</h3>
                                                    <p>{{ info.subtitle }}</p>
                                                        <div class="flex mb-2">
                                                            <div v-for="star in stars" :key="star">
                                                                <li v-if="clickedComment.rating >= star" class="fas fa-star fa-sm text-yellow-500 mr-1"></li>
                                                                <li v-if="clickedComment.rating < star" class="far fa-star fa-sm text-yellow-500 mr-1"></li>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-500 break-words">
                                                                {{ clickedComment.comment }}
                                                            </p>
                                                        </div>
                                                        <ul class="meta">
                                                            <li class="icon fa-clock">{{clickedComment.updated_at}}</li>
                                                            <li class="icon fa-comments">{{info.ratingCount}}</li>
                                                        </ul>
                                                        <a v-bind:href="`/room/${info.id}`" class="button">전체 정보 보러가기</a>

                                                </header>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col-3 col-12-medium">
                                        <div class="sidebar">
                                            <!-- Archives -->
                                            <ul class="divided">
                                                <li v-for="comment in comments" :key="comment">
                                                    <article class="box post-summary">
                                                        <h3><li class="hover:text-gray-300" @click="changeComment(comment)">{{ comment.movie_info[0].title }}</li></h3>
                                                        <li class="truncate">{{comment.comment}}</li>
                                                        <div class="flex mt-1">
                                                            <div v-for="star in stars" :key="star">
                                                                <li v-if="comment.rating >= star" class="fas fa-star fa-sm text-yellow-500 mr-1"></li>
                                                                <li v-if="comment.rating < star" class="far fa-star fa-sm text-yellow-500 mr-1"></li>
                                                            </div>
                                                        </div>
                                                        <div class="flex mt-2 text-gray-500">
                                                            <li class="icon fa-clock">{{comment.updated_at}}</li>
                                                            <li class="icon fa-comments"><a v-bind:href="`/room/${comment.movie_info[0].id}`">{{comment.movie_info[0].ratingCount}}</a></li>
                                                        </div>
                                                    </article>
                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
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
            axios.post('show/comments')
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





}
</script>
