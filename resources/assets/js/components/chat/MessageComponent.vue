<template>
    <div class="card">
        <div class="card-action grey lighten-3">
            <span :class="{'red-text':sessionBlocked}">
                {{ friend.name }}
                <span v-if="sessionBlocked">(BLOCKED)</span>
            </span>

            <!--Close btn-->
            <a href="#" @click="close">
                <i class="material-icons right icon-indigo">close</i>
            </a>
            <!--Options-->
            <!-- Dropdown Trigger -->
            <div class="right">
                <!--<a class='dropdown-trigger' href='#' data-target='dropdown1'>-->
                    <!--<i class="material-icons right">apps</i>-->
                <!--</a>-->

                <!--&lt;!&ndash; Dropdown Structure &ndash;&gt;-->
                <!--<ul id='dropdown1' class='dropdown-content'>-->
                    <!--<li v-if="!sessionBlocked"><a href="#" @click="block" >Block</a></li>-->
                    <!--<li v-if="sessionBlocked"><a href="#" @click="unBlock">UnBlock</a></li>-->
                    <!--<li><a href="#" @click="clear">Clear</a></li>-->
                <!--</ul>-->
            </div>
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
                        :disabled="sessionBlocked"
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
                this.chats = []
            },
            block(){
                this.sessionBlocked = true
            },
            unBlock(){
                this.sessionBlocked = false
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
        },
    }
</script>

<style scoped>
    .chat-box{
        overflow-y: scroll;
        height: 50vh;
    }
</style>