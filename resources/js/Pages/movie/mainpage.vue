<template>
    <app-layout>
    <div>
        <h1>최근 평가된 영화</h1>
        <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-5">
            <div v-for="movie in movies" :key="movie" class="rounded overflow-hidden shadow-lg w-29">
                <img class="w-full" :src="`${movie.image_path}`" alt="Movie Image">
                <p>제목 : {{movie.title}}</p>
                <p>네이버 평점 ★ 3.04</p>
            </div>
        </div>
    </div>
    </app-layout>
</template>

<script>
import axios from 'axios'
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
  components: {
      AppLayout
   },
    data(){
        return{
            movies:[],
            search:''
        }
    },
    methods:{
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

        }
    },
    mounted(){
        this.MainShowMovie()
    }
}
</script>
