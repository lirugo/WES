<template>
    <div>
        <div class="col s12 m8">
            <conversation :conversation="conversation" :id="id" @updateConversation="onUpdateConversation"></conversation>
        </div>
        <div class="col s12 m4">
            <conversation-form :users="users" @createConversation='onCreateConversation'></conversation-form>
            <div class="card">
                <div class="card-content p-t-0 p-b-0 p-r-0 p-l-0">
                    <div class="collection hoverable">
                        <a class="collection-item avatar p-b-5 black-text" v-for="conversation in conversations" @click="getConversation(conversation.id)" style="cursor:pointer;">

                            <i class="material-icons circle m-t-10" v-if="conversation.participant_count <= 1">person</i>
                            <i class="material-icons circle m-t-10" v-else>group</i>

                            <span class="title">{{conversation.body.length > 50 ? conversation.body.substr(0, 50) + '...' : conversation.body}}</span>
                            <p>
                                <small>You and {{conversation.participant_count}} {{pluralize('other', conversation.participant_count)}}</small>
                                <br/>
                                <small>Last reply - {{conversation.last_reply_human}} </small>
                            </p>
                            <ul class="m-t-0 m-b-0">
                                <li>
                                    <img :src="'/uploads/avatars/'+user.avatar" :title="user.name" v-for="user in conversation.users" class="p-r-5" width="35px">
                                </li>
                            </ul>
                        </a>
                        <p class="m-t-5 m-b-5 m-l-5" v-if="conversations.length == 0">Create new conversation...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pluralize from 'pluralize'
    export default {
        mounted(){
            this.getConversations()
        },
        props: ['id', 'users'],
        data(){
            return {
                conversations: [],
                conversation: '',
            }
        },
        methods: {
            onCreateConversation (data) {
               this.getConversations()
               this.getConversation(data.id)
            },
            onUpdateConversation(data){
                let conv = this.conversations.find((c) => {
                    return c.id == data.reply.parent_id ? c : null
                })
                this.conversations = this.conversations.filter(c => {
                    return c.id != conv.id
                })
                conv.last_reply_human = 'Just Now'

                this.conversations.unshift(conv)
            },
            getConversations(){
                axios.get('/api/conversations').then(res => {
                    this.conversations = res.data.data
                })

                console.log(Laravel.user.id)

                Echo.private('user.'+Laravel.user.id)
                    .listen('ConversationCreated', (e) => {
                        axios.get('/api/conversations').then(res => {
                            this.conversations = res.data.data
                        })
                    })
            },
            getConversation(id){
                axios.get('/api/conversations/' + id).then(res => {
                    this.conversation = res.data.data
                })

                window.history.pushState(null, null, '/conversations/' + id)
            },
            pluralize: pluralize,
        },


    }
</script>