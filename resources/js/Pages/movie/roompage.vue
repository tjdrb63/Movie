<template>

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
                        <h2 class="text-3xl font-bold">{{movie.title}}</h2><br>
                        <div class="bg-green-400 font-bold rounded-xl p-2 ml-2 mr-1">{{movie.userRating}}</div>
                        <div class="bg-yellow-400 font-bold rounded-xl p-2">7.45</div>
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
                </div>
            </div>
            <!-- 댓글 구간 -->
            <div class="bg-white border-gray-100 sm:rounded-3xl p-8 space-x-8 mt-2">
               <!-- 댓글 -->
               <div class="bg-gray-200 rounded-lg p-3 flex flex-col justify-center items-center md:items-start shadow-lg mb-4 ">
                    <div class="flex flex-row justify-center mr-2 ">
                        <img alt="avatar" width="48" height="48" class="rounded-full w-10 h-10 mr-4 shadow-lg mb-4" src="https://cdn1.iconfinder.com/data/icons/technology-devices-2/100/Profile-512.png">
                        <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left ">@Shanel</h3>
                    </div>
                 <p style="width: 90%" class="text-gray-600  text-lg text-center md:text-left ">이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요이영화 정말 좋아요 </p>
                </div>
            </div>
            <!-- 댓글 버튼 -->
            <button @click="show()" type="button" class="w-full border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                리뷰 남기러 가기
            </button>
        </div>

    </div>

    <dialog-modal :show="showmodal">
        <template #content>
            <div>
                <div class="h-96"></div>
                <div class="max-w-5xl mx-auto px-6 sm:px-6 lg:px-8 mb-12">
                    <div class="bg-white w-full shadow-lg rounded p-8 sm:p-12 -mt-72">
                        <p class="text-3xl font-bold leading-7 text-center">리뷰 남기기</p>
                            <div class="md:flex items-center mt-8">
                                <div class="w-full flex flex-col">
                                    <label class="font-semibold leading-none">평점칸</label>
                                    <input  v-model="comment_rating" type="text" class="leading-none text-gray-900 p-3 focus:outline-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200"/>
                                </div>

                            </div>
                            <div>
                                <div class="w-full flex flex-col mt-8">
                                    <label class="font-semibold leading-none">리뷰 내용</label>
                                    <textarea  v-model="comment_content" type="text" class="h-40 text-base leading-none text-gray-900 p-3 focus:oultine-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200"></textarea>
                                </div>
                            </div>
                            <div class="flex items-center space-x-8 justify-center w-full">
                                <button @click="PostComment()" class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-blue-700 rounded hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
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
import DialogModal from '../../Jetstream/DialogModal.vue'


export default {
    components:{
        DialogModal,
    },
    props:['data'],
    data(){
        return{
            movie:"",
            showmodal:false,
            comment_rating:"",
            comment_content:"",
            comments:""
        }
    },
    methods:{
        close(){
            this.showmodal=false
        },
        show(){
            this.showmodal=true
        },
        PostComment(){
            axios.post('/post/comment/'+this.data,{
                'comment_rating':this.comment_rating,
                'comment_content':this.comment_content,
            })
            .then(res=>{
                console.log("성공적으로 전송")
            })

        },
        CommentInfo(){
            axios.post('/comment/info/'+this.data)
            .then(res=>{
                this.comments = res.data
            })
        },
        RoomInfo(){
            axios.post('/room/info/'+this.data)
            .then(res=>{
                console.log(res)
                console.log("방정보 돌아옴.")
                this.movie = res.data;
            })
        }
    },
    created(){
        this.CommentInfo()
        this.RoomInfo()
    }
}
</script>
