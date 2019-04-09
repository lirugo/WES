<template>
    <form @submit.prevent="reply()">
        <div class="input-field m-r-10 m-l-10">
            <textarea id="textarea1" class="materialize-textarea" v-model="body" required></textarea>
            <label for="textarea1">Enter new message</label>
            <button type="submit" class="waves-effect waves-light btn btn-small m-b-10 indigo" style="width:100%"><i class="material-icons right">send</i>Send new message</button>
        </div>
    </form>
</template>

<script>
    export default {
        props:['id'],
        data(){
            return {
                body: null,
            }
        },
        methods: {
            reply(){
                axios.post('/api/conversations/'+this.id+'/reply', {body: this.body})
                    .then((res) => {
                        this.body = null
                        this.$emit('reply', {
                            reply: res.data.data
                        })
                    })
            },
        }
    }
</script>