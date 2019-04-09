<template>
    <div class="card hoverable" v-if="selectedConversation">
        <ul class="m-t-0 m-b-0">
            <li>
                <img :src="'/uploads/avatars/'+user.avatar" :title="user.name" v-for="user in selectedConversation.users" class="" width="35px"  style="margin-bottom: -5px;">
                <span class="p-t-5 p-r-10 right"><strong>{{selectedConversation.body}}</strong></span>
            </li>
        </ul>
        <div class="card-content p-b-0 p-t-0 p-l-0 p-r-0">
            <ul class="collection with-header m-t-0 m-b-0 chat-box" v-chat-scroll>
                <li class="collection-item p-b-15 p-t-10 p-l-10 p-r-10" style="border-bottom: 1px solid #eeeeee;">
                    <div class="title">
                        <img :src="'/uploads/avatars/' + selectedConversation.user.avatar" alt="" class="circle left m-b-10" width="35px">
                        <p class="p-t-5 p-l-40">
                            {{selectedConversation.user.name}} | {{selectedConversation.body}}
                        </p>
                    </div>
                </li>
                <li class="collection-item p-b-15 p-t-10 p-l-10 p-r-10" :class="{'right-align': reply.user.id == authId}" style="border-bottom: 1px solid #eeeeee;" v-for="reply in selectedConversation.replies">
                    <div class="title">
                        <img :src="'/uploads/avatars/' + reply.user.avatar" alt="" class="circle m-b-10"
                             :class="{'left': reply.user.id != authId, 'right': reply.user.id == authId}"
                             width="35px">
                        <p class="p-t-5 p-l-40" :class="{'m-r-40': reply.user.id == authId}">
                            {{reply.user.name}} | {{reply.body}} | <small>{{reply.created_at_human}}</small>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <conversation-reply-form :id="selectedConversation.id" @reply='onReply'></conversation-reply-form>
    </div>

    <div class="card" v-else>
        <div class="card-content">
            Select or create any conversation
        </div>
    </div>
</template>

<script>
    export default {
        props: ['conversation', 'id'],
        mounted(){
            if(this.id != null){
                this.getConversation(this.id)
            }
        },
        data(){
            return {
                selectedConversation: this.conversation,
                authId: Laravel.user.id
            }
        },
        watch: {
            conversation: function () {
                this.selectedConversation = this.conversation
            }
        },
        methods: {
            getConversation(id){

                //leave...

                axios.get('/api/conversations/' + id).then(res => {
                    this.selectedConversation = res.data.data
                })

                //subscribe
                Echo.private('conversation.' + id)
                    .listen('ConversationReplyCreated', (e) => {
                        console.log(e)
                        console.log(this.selectedConversation)
                        if(this.selectedConversation.id == id) {
                            axios.get('/api/conversations/' + id).then(res => {
                                this.selectedConversation = res.data.data
                            })
                        }else{

                        }
                    });
            },
            onReply (data) {
                this.selectedConversation.replies.push(data.reply)

                this.$emit('updateConversation', {
                    reply: data.reply
                })
            }
        },
    }
</script>

<style scoped>
    .chat-box{
        overflow-y: scroll;
        height: 50vh;
    }
</style>