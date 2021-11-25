<template>
        <app-layout>
            <div>
                <input v-model="data"> <button v-on:click="search">검색하기</button>
                <table class="w-full">
                    <thead>
                        <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                            <th class="px-4 py-3">영화제목</th>
                            <th class="px-4 py-3">평점</th>
                            <th class="px-4 py-3">개봉년도</th>
                            <th class="px-4 py-3">평가상태</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white" v-for="movie in movies" :key="movie">
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">
                            <div class="flex items-center text-sm">
                                <div class="relative w-20 h-50 mr-3 rounded-full md:block">
                                    <img class="h-full rounded"  :src="`${movie.image}`" alt="이미지 준비중" loading="lazy" />
                                    </div>
                                <div>
                                    <p class="font-semibold text-black">{{movie.title}}  </p>
                                    <span v-html="movie.subtitle" class="text-xs text-gray-600"/>
                                </div>
                            </div>
                            </td>
                            <td class="px-4 py-3 text-ms font-semibold border">
                                네이버 ★ : {{ movie.userRating }}<br>
                                사이트 평점 ★: 7.77
                            </td>
                            <td class="px-4 py-3 text-sm border">
                                {{ movie.pubDate }}
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                <span v-if="movie.isOn" v-on:click="ShowComment(movie)" class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm"> 리뷰방 보러가기 </span>
                                <span v-else v-on:click="MakeRoom(movie)" class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm"> 등록된 평점 없음 </span>
                            </td>
                        </tr>
                    </tbody>

                 </table>
            </div>
        </app-layout>
</template>
<script>

import AppLayout from '../../Layouts/AppLayout.vue'
export default {
    props:['data'],
    components:{
        AppLayout
    },
    data(){
        return{
            movies:[],
            checkrooms:[]
        }
    },
    methods:{
        ShowComment($res){
            console.log($res)
            axios.post('/show/room/'+$res.title)
            .then(res=>{
                console.log(res.data)
                window.location.href="/room/"+res.data.id
            })
        },
        search(){
            if(this.data)
                window.location.href="/search/"+this.data
            else
                alert("검색어를 입력해주세요")
        },
        SearchApiCall(){
            axios.get('/search/api/'+this.data)
            .then(res=>{
                console.log(res)
                this.movies = res.data.items;
            })
        },
        MakeRoom($res){
            var result = confirm("리뷰 댓글방을 생성 하시겠습니까?");
            if(result){
                axios.post('/make/room',{
                    "title":$res.title,
                    "subtitle":$res.subtitle,
                    "pubDate":$res.pubDate,
                    "actor":$res.actor,
                    "director":$res.director,
                    "image":$res.image,
                    "userRating":$res.userRating
                })
                .then(res=>{
                    alert("성공적으로 생성 되었습니다.")
                    console.log("리뷰 댓글방 생성")
                    window.location.href="/room/"+res.data
                })
            }
            else{
                console.log("취소")
            }
        }
    },
    created(){
        if(this.data){
            this.SearchApiCall()
        }
        else
            console.log("검색 공백")
        }
    }
</script>
