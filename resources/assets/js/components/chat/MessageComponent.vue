<template>
    <div class="card">
        <div class="card-action grey lighten-3">
            <span :class="{'red-text':session.block}">
                {{ friend.name }}
                <small v-if="isTyping">
                    <i>is typing...</i>
                </small>
                <span v-if="session.block">(BLOCKED)</span>
            </span>

            <!--Close btn-->
            <a href="#" @click="close">
                <i class="material-icons right icon-indigo">close</i>
            </a>
            <!--Clear btn-->
            <a href="#" @click="clear">
                <i class="material-icons right icon-indigo">delete</i>
            </a>
            <!--Block btn-->
            <a href="#" @click="block" v-if="!session.block">
                <i class="material-icons right icon-indigo">lock</i>
            </a>
            <!--UnBlock btn-->
            <a href="#" @click="unBlock" v-if="session.block && can">
                <i class="material-icons right icon-indigo">lock_open</i>
            </a>
        </div>
        <div class="card-content chat-box p-b-0 p-t-0 p-l-0 p-r-0" v-chat-scroll>
            <ul class="collection with-header m-t-0 m-b-0">
                <li class="collection-item"
                    :class="{'right-align':chat.type == 0, 'grey lighten-3':chat.read_at != null}"
                    v-for="chat in chats" :key="chat.id">
                    {{ chat.message }}
                    <br/>
                    <span v-if="chat.read_at != null">
                        <small>
                             read {{ chat.read_at }}
                        </small>
                    </span>
                </li>
            </ul>
        </div>
        <div class="card-action p-t-0 p-b-0">
            <form @submit.prevent="send">
                <div class="input-field">
                    <i class="material-icons prefix">textsms</i>
                    <input type="text" id="autocomplete-input" class="autocomplete"
                        :disabled="session.block ? true : false"
                        v-model="message">
                    <label for="autocomplete-input">Type new message...</label>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['friend'],
        data(){
            return {
                chats: [],
                sessionBlocked: false,
                message: '',
                isTyping: false,
            }
        },
        computed: {
            session(){
                return this.friend.session;
            },
            can(){
                return this.session.blocked_by == auth.id
            },
        },
        watch:{
            message(value){
                if(value){
                    Echo.private('Chat.' + this.friend.session.id)
                        .whisper('typing', {
                            name: authName
                        })
                }
            }
        },
        methods:{
            close(){
                this.$emit('close')
            },
            send(){
                {
                    this.chats.push({
                        message:this.message,
                        type: 0,
                        read_at: null,
                        sent_at: 'Just Now'
                    })

                    axios.post('/api/chat/' + this.friend.session.id + '/message', {
                            message: this.message,
                            toUser: this.friend.id
                        })
                        .then(res => {
                            this.chats[this.chats.length - 1].id = res.data
                        })

                    this.message = null
                }
            },
            clear(){
                axios.post('/api/chat/' + this.friend.session.id + '/clear')
                    .then(res => {
                        this.chats = []
                    })
            },
            block(){
                axios.post('/api/chat/' + this.friend.session.id + '/block')
                    .then(res => {
                        this.session.block = true
                        this.session.blocked_by = auth.id
                    })
            },
            unBlock(){
                axios.post('/api/chat/' + this.friend.session.id + '/unblock')
                    .then(res => {
                        this.session.block = false
                        this.session.blocked_by = null
                    })
            },
            getAllMessages(){
                axios.get('/api/chat/' + this.friend.session.id + '/chats',)
                    .then(res => {
                        this.chats = res.data.data
                    })
            },
            read(){
                axios.post('/api/chat/' + this.friend.session.id + '/read')
                    .then(res => {
                        console.log(res)
                    })
            }
        },
        created(){
            this.read()

            this.getAllMessages()

            Echo.private('Chat.' + this.friend.session.id).listen('PrivateChatEvent', (e) => {
                this.friend.session.open ? this.read() : ''
                this.chats.push({
                    message: e.content,
                    type: 1,
                    sent_at: 'Just Now'
                })
            })

            Echo.private('Chat.' + this.friend.session.id).listen('MsgRead', (e) => {
                this.chats.forEach(chat => chat.id == e.chat.id ? chat.read_at = e.chat.read_at : '')
            })


            Echo.private('Chat.' + this.friend.session.id).listenForWhisper('typing', (e) => {
                this.isTyping = true
                setTimeout(() => {
                    this.isTyping = false
                }, 2000)
            })
        },
    }
</script>

<style scoped>
    .chat-box{
        overflow-y: scroll;
        height: 50vh;
    }
</style>