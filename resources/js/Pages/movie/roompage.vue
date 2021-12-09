<template>
    <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.11.2/css/all.css"
    />

            <nav>
                <ul class="h-10">
                    <li><a class="m-2" href="/main">메인으로 돌아가기</a></li>
                </ul>
            </nav>
    <div class="min-h-screen bg-gray-300 py-6 flex flex-col justify-center sm:py-12 font-apple-system">
        <div class="py-3 sm:max-w-4xl sm:mx-auto">
                    <!-- 타이틀바 -->
            <div class="bg-gray-700 sm:rounded-3xl mb-1 p-6 flex text-white font-semibold text-3xl">
                영화 소개
            </div>
                    <!-- 영화소개 -->
            <div class="bg-white shadow-lg border-gray-100 border sm:rounded-3xl p-8 flex space-x-8">
                <div class="w-100">
                    <img class="rounded-3xl shadow-lg" :src="`${movie.image_path}`" alt="image">
                </div>
                <div class="flex flex-col w-1/2 space-y-4">
                    <div class="flex justify-between items-start">
                        <h2 class="mt-2 text-3xl font-bold">{{movie.title}}</h2><br>

                    </div>
                    <h2 class="text-sm text-gray-400">{{movie.subtitle}}</h2>
                    <div>
                        <div class="text-sm text-gray-400">개봉일자</div>
                        <div class="text-lg text-gray-800">{{movie.pubDate}}</div>
                    </div>
                    <div class="text-sm text-gray-400">등장인물</div>
                    <p class=" text-gray-800 max-h-40 overflow-y-hidden">{{movie.actor}}</p>
                    <div class="text-sm text-gray-400">감독</div>
                    <div class="text-lg text-gray-800">{{movie.director}}</div>

                    <div class="text-sm text-gray-400">평점</div>
                    <div class="relative flex">
                            <div class="mt-2 bg-green-400 font-bold rounded-xl p-2 text-white ">N {{movie.userRating}}</div>
                            <i class="absolute left-20 fas fa-star fa-3x text-yellow-500"></i>
                            <div  class="absolute left-20 pl-4 pt-3 font-bold "> {{ calRating }} </div>
                    </div>
                </div>
            </div>
            <!-- 댓글 구간 -->
            <div class="bg-white border-gray-100 sm:rounded-3xl p-8 mt-2">
                <div v-if="comments.data==''">
                    작성된 리뷰가 없어요

                </div>
                <div v-else>
                    <!-- PAGINATE -->
                    <div class="text-center">
                        <button v-if="current_page==1" class="bg-gray-300 border-2 border-black font-bold py-2 px-4 rounded center"> &lt; </button>
                        <button v-if="current_page!=1" @click="[current_page+=-1,CommentInfo()]" class="bg-white hover:bg-gray-200 border-2 border-black font-bold py-2 px-4 rounded center"> &lt; </button>
                        <button v-for="i in last_page" :key="i" @click="[current_page=i,CommentInfo()]">
                            <div v-if="current_page == i"  class="bg-gray-300 hover:bg-gray-400 border-2 border-black font-bold py-2 px-4 rounded center">{{ i }} </div>
                            <div v-if="current_page != i"  class="bg-white hover:bg-gray-200 border-2 border-black font-bold py-2 px-4 rounded center">{{ i }}</div>
                        </button>
                        <button v-if="current_page!=last_page" @click="[current_page+=1,CommentInfo()]" class="bg-white-500 hover:bg-gray-200 border-2 border-black font-bold py-2 px-4 rounded center"> &gt; </button>
                        <button v-if="current_page==last_page" class="bg-gray-300 border-2 border-black font-bold py-2 px-4 rounded center"> &gt; </button>
                    </div>
                    <!-- 댓글 -->
                    <div v-for="comment in comments.data" :key="comment" class="bg-gray-200 rounded-lg p-3 flex flex-col justify-center items-center md:items-start shadow-lg mb-4 ">
                        <div class="flex flex-row justify-center mr-2 ">
                            <img  width="48" height="48" class="rounded-full w-10 h-10 mr-4 shadow-lg mb-2" :src="`${comment.user_imagePath}`" alt="noimage">
                            <h3 class="text-black font-semibold text-lg text-center md:text-left mr-3">{{comment.user_name}}</h3>
                            <div v-for="star in stars" :key="star">
                                <i v-if="comment.rating >= star" class="fas fa-star fa-sm text-yellow-500 mr-1"></i>
                                <i v-if="comment.rating < star" class="far fa-star fa-sm text-yellow-500 mr-1"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 w-full text-lg text-center md:text-left ">{{comment.comment}}</p>
                    </div>
                </div>
            </div>

            <!-- 댓글 버튼 -->
            <button v-if="user==null" @click="login()"  type="button" class="w-full border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                로그인하기
            </button>
            <div v-else>
                <button v-if="commentCheck==0" @click="show()" type="button" class="w-full border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                    리뷰 남기러 가기
                </button>
                <button v-if="commentCheck==1" @click="Editshow()" type="button" class="w-full border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                    리뷰 수정하기
                </button>
            </div>
        </div>

    </div>

    <!-- Modal 화면 -->
    <dialog-modal :show="showmodal">
        <template #content>
            <div v-if="check==0">
                <input  ref="image" @change="upload" accept="image/*" type="file" id="file" class="inputfile"/>
                <img :src="this.url"/>
                <button @click="movieCheck()" class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-blue-700 rounded hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
                    인증하기
                </button>
                <button @click="close()" class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-red-700 rounded hover:bg-red-600 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:outline-none">
                    나가기
                </button>
            </div>
            <div v-if="check==1">
                처리하는중...
            </div>
            <div v-if="check==2">
                <div class="h-96"></div>
                <div class="max-w-5xl mx-auto px-6 sm:px-6 lg:px-8 mb-12">
                    <div class="bg-white w-full shadow-lg rounded p-8 sm:p-12 -mt-72">
                        <p class="text-3xl font-bold leading-7 text-center">리뷰 남기기</p>
                            <div class="md:flex items-center mt-8">
                                <div class="w-full flex flex-col">
                                    <ul class="flex justify-center">
                                        <div v-for="star in stars" :key="star">
                                            <li>
                                                <div @click="Starcheck(star)">
                                                    <i v-if="starCount >= star" class="fas fa-star fa-2x text-yellow-500 mr-1"></i>
                                                    <i v-if="starCount < star" class="far fa-star fa-2x text-yellow-500 mr-1"></i>
                                                </div>
                                            </li>
                                        </div>
                                    </ul>
                                 </div>
                            </div>
                            <div>
                                <div class="w-full flex flex-col mt-8">
                                    <label class="font-semibold leading-none">내용</label>
                                    <textarea v-model="comment_content" type="text" class="h-40 text-base leading-none text-gray-900 p-3 focus:oultine-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200"></textarea>
                                </div>
                            </div>
                            <div class="flex items-center space-x-8 justify-center w-full">
                                <button @click="EditComment()" v-if="commentCheck==1" class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-green-700 rounded hover:bg-green-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
                                    수정하기
                                </button>
                                <button @click="DeleteComment()" v-if="commentCheck==1" class="mt-9 text-md font-semibold leading-none text-white py-4 px-8 bg-red-700 rounded hover:bg-red-600 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:outline-none">
                                    삭제하기
                                </button>
                                <button @click="PostComment()" v-else class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-blue-700 rounded hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
                                    작성하기
                                </button>
                                <button @click="close()" class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-red-700 rounded hover:bg-red-600 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:outline-none">
                                    나가기
                                </button>
                            </div>
                   </div>
                </div>
            </div>

        </template>
    </dialog-modal>
</template>


<script>
import axios from 'axios'
import DialogModal from '../../Jetstream/DialogModal.vue'


export default {
    components:{
        DialogModal,
    },
    props:['data','user'],
    data(){
        return{
            current_page:1,
            last_page:"",
            movie:"",
            showmodal:false,
            comment_content:"",
            comments:"",
            calRating:0,
            stars:[1,2,3,4,5],
            starCount:3,
            image:"",
            url:"",
            check:0,
            commentCheck:0,
            userComment:""
        }
    },
    methods:{
        login(){
                window.location.href="/login";
        },
        DeleteComment(){
            axios.post("/delete/comment/"+this.userComment.id)
            .then(res=>{
                this.CommentInfo()
                this.RoomInfo()
                this.UserComment()
                this.close()
            })
        },
        EditComment(){
            axios.post("/edit/comment/"+this.userComment.id,{
                'comment' : this.comment_content,
                'rating':this.starCount,
                'room_id':this.data
            })
            .then(res=>{
                this.CommentInfo()
                this.RoomInfo()
                this.UserComment()
                this.close()
                console.log(res.data)
            })

        },
        upload(){
            this.image = this.$refs['image'].files[0]
             this.url = URL.createObjectURL(this.image);
            console.log(this.image)
        },
        movieCheck(){
            console.log("인증시작")
            this.check=1
            const formData = new FormData()
            if(this.image){
                console.log(this.movie.title)
                formData.append('file',this.image)
                formData.append('title',this.movie.title)
                axios.post('/api/call/text',
                    formData,
                    {
                        headers:{
                                'Content-type':'multipart/form-data'
                        }
                    }
                ).then(res=>{
                    console.log(res.data)
                    if(res.data =="확인완료")
                        this.check=2
                    else{
                        alert("인증 불가.")
                        this.check=0
                    }
                }).catch(err=>{
                    alert("사진 오류")
                    this.check=0
                })
            }
        },
        Starcheck($star){
            this.starCount = $star
        },
        close(){
            this.showmodal=false
        },
        show(){
            this.showmodal=true
        },
        Editshow(){
            this.starCount=this.userComment.rating
            this.comment_content=this.userComment.comment
            this.showmodal=true
        },
        PostComment(){
            axios.post('/post/comment/'+this.data,{
                'comment_rating':this.starCount,
                'comment_content':this.comment_content,
            })
            .then(res=>{
                console.log("성공적으로 전송")
                this.commentCheck=1
                this.close()
                this.RoomInfo()
                this.UserComment()
                this.CommentInfo()
            })

        },
        CommentInfo(){
            axios.post('/comment/info/'+this.data+"?page="+this.current_page)
            .then(res=>{
                this.comments = res.data
                this.current_page=res.data.current_page,
                this.last_page=res.data.last_page,
                console.log(res.data)

            })
        },
        RoomInfo(){
            axios.post('/room/info/'+this.data)
            .then(res=>{
                // console.log(res)
                console.log("방정보 돌아옴.")
                this.movie = res.data;
                if(this.movie.totalRating ==0)
                    this.calRating = (0.0).toFixed(1);
                else
                    this.calRating = (this.movie.totalRating/this.movie.ratingCount).toFixed(1)

            })
        },
        UserComment(){
            axios.post('/check/comment/'+this.data)
            .then(res=>{
                console.log(res.data[0])
                if(res.data=='')
                    this.commentCheck=0
                else{
                    this.commentCheck=1
                    this.userComment=res.data[0]
                    this.check=2
                }
            })
        }

    },
    created(){
        this.CommentInfo()
        this.RoomInfo()
        this.UserComment()
    }
}
</script>
