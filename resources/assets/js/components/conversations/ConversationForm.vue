<template>
    <div class="card">
        <div class="card-content p-t-0 p-b-0">
            <div class="row">
                <div class="input-field col s12 m-b-0 m-t-15">
                    <i class="material-icons prefix">title</i>
                    <input id="icon_prefix1" type="text" class="validate" v-model="body">
                    <label for="icon_prefix1">Type name of conversations</label>
                </div>
                <div class="input-field col s12 m-b-10 m-t-0">
                    <i class="material-icons prefix">account_circle</i>
                    <select v-model="selectedUser" @change="addUser()">
                        <option value="" disabled selected>Add members</option>

                        <option v-for="(user, index) in users"
                                :key="index"
                                :value="user"
                                :data-icon="'/uploads/avatars/'+user.avatar"
                        >{{ user.full_name }}
                        </option>

                    </select>
                    <div class="chip" v-for="user in selectedUsers">
                        <img :src="'/uploads/avatars/'+user.avatar" :title="user.full_name">
                        {{user.name}}
                        <i class="material-icons chip-icon" @click="removeUser(user.id)">close</i>
                    </div>
                    <a class="btn waves-effect waves-light btn-small green right" v-if="selectedUsers.length >= 1" @click="send()">create</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['users', 'createConversation'],
        data(){
            return {
                selectedUser: '',
                selectedUsers: [],
                body: null,
                recipients: [],
            }
        },
        methods: {
            addUser(){
                let exist = this.selectedUsers.find(u => {
                    return u.id == this.selectedUser.id ? true : false
                })

                if(typeof(exist) == 'undefined')
                    this.selectedUsers.push(this.selectedUser)

                this.selectedUser = ''

            },
            removeUser(id){
                this.selectedUsers = this.selectedUsers.filter(u => {
                    return u.id != id
                })
            },
            send(){
                this.selectedUsers.forEach(u => {
                    this.recipients.push(u.id)
                })
                axios.post('/api/conversations/', {
                    body: this.body,
                    recipients: this.recipients
                })
                    .then(res => {
                        this.selectedUsers = []
                        this.recipients = []
                        this.body = null
                        console.log(res)
                        this.$emit('createConversation', {
                            id: res.data.data.id,
                        })
                    })
            }
        }
    }
</script>