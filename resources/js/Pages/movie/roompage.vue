<template>
    <div>
        댓글목록 보여주기
    </div>
</template>


<script>
export default {
    props:['room_id'],
    data(){
        return{
            movie:""
        }
    },
    methods:{
        RoomInfo(){
            axios.post('/room/info/'+this.room_id)
            .then(res=>{
                console.log("방정보 돌아옴.")
                this.movie = res.data;
            })
        }
    },
    created(){
        this.RoomInfo()
    }
}
</script>
