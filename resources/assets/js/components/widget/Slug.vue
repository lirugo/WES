<template>
        <div class="valign-wrapper" id="slug">
            <i class="material-icons m-r-10">attachment</i>
                <span>{{url}}</span
                ><span>{{subdirectory}}</span
                ><span class="yellow lighten-1 p-l-5 p-r-5">{{slug}}</span>
                <input :value="slug" name="name" hidden/>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Slug widget mounted.')
        },
        props: {
            url: {
                type: String,
                required: true
            },
            subdirectory: {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            }
        },
        data: function () {
            return {
                slug: this.convertTitle()
            }
        },
        methods:{
            convertTitle: function(){
                return Slug(this.title)
            }
        },
        watch: {
            title: function() {
                this.slug = this.convertTitle();
            }
        }
    }
</script>
