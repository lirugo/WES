<template>
    <div class="row">
        <conversations :id="id" :users="users"></conversations>
    </div>
</template>

<script>
    export default {
        props: {
            'id': {
                default: null
            },
            'users': {
                default: []
            }
        },
        mounted(){
            console.log('Component conversations dashboard ready')
        }
    }
</script>