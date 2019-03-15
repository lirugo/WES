<template>
    <div class="row">
        <div class="col sm12 m12 l12 xl9">
            <div v-for="friend in friends" v-if="friend.session">
                <message-component
                        v-if="friend.session.open"
                        @close="close(friend)"
                        :friend="friend"
                />
            </div>
        </div>
        <div class="col sm12 m12 l12 xl3">
            <div class="card">
                <div class="card-action grey lighten-3">
                    USERS
                </div>
                <div class="card-content chat-friends-list p-b-0 p-t-0 p-l-0 p-r-0">
                    <div class="collection m-t-0">
                        <a href="#" class="collection-item avatar hoverable black-text"
                           v-for="friend in friends"
                           :key="friends.id"
                           @click="openChat(friend)">
                            <img src="/uploads/avatars/male.png" alt="" class="circle m-t-10">
                            <span class="title">
                                {{ friend.name }}
                                <span class="red-text" v-if="friend.session && friend.session.unreadCount > 0">({{friend.session.unreadCount}})</span>
                            </span>
                            <p>
                                {{ friend.email }}
                                <br>
                                {{ friend.phone }}
                            </p>
                            <a href="#!" class="secondary-content"><i class="material-icons" :class="{'icon-green':friend.online, 'icon-grey':!friend.online}">brightness_1</i></a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                friends: [],
            }
        },
        methods:{
            close(friend){
                friend.session.open = false
            },
            getFriends(){
                axios.get('/api/chat/friends')
                    .then(res => {
                        this.friends = res.data.data
                        this.friends.forEach(friend => {
                            if(friend.session) {
                                this.listenForEverySession(friend)
                            }
                        })
                    })
            },
            openChat(friend){
                // Close all chat
                if(friend.session){
                    this.friends.forEach(friend => {
                        friend.session ? friend.session.open = false : ''
                    })
                    friend.session.open = true
                    friend.session.unreadCount = 0
                }else{
                    this.createSession(friend)
                }
            },
            createSession(friend){
                axios.post('/api/chat/session', friend)
                    .then(res => {
                        console.log(res.data.data)
                        friend.session = res.data.data
                        friend.session.open = true
                    })
            },
            listenForEverySession(friend){
                Echo.private('Chat.' + friend.session.id).listen('PrivateChatEvent', (e) => {
                    friend.session.open ? '' : friend.session.unreadCount++
                })
            },
        },
        created() {
            this.getFriends()

            Echo.channel('Chat').listen("SessionEvent", e => {
                console.log(e)
                let friend = this.friends.find(friend => friend.id === e.session_by);
                friend.session = e.session
                this.listenForEverySession(friend)
            })

            Echo.join('Chat')
                .here((users) => {
                    this.friends.forEach(friend => {
                        users.forEach(user => {
                            if(user.id === friend.id){
                                friend.online = true
                            }
                        })
                    })
                })
                .joining((user) => {
                    this.friends.forEach(friend => user.id === friend.id ? friend.online = true : '')
                })
                .leaving((user) => {
                    this.friends.forEach(friend => user.id === friend.id ? friend.online = false : '')
                })
        },
    }
</script>

<style scoped>
    .chat-friends-list{
        overflow-y: scroll;
        height: 100vh;
    }
</style>