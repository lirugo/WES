<template>
    <div class="row center m-b-0" id="countdown-template">
        <div class="col s4">
            <p class="digit">{{ hours }}</p>
            <p class="text">Hours</p>
        </div>
        <div class="col s4">
            <p class="digit">{{ minutes }}</p>
            <p class="text">Minutes</p>
        </div>
        <div class="col s4">
            <p class="digit">{{ seconds }}</p>
            <p class="text">Seconds</p>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            window.setInterval(() => {
                if(this.left > 0)
                    this.left = this.left - 1;
            }, 1000);
        },
        props: {
            time: Number,
            endTime: null
        },
        data() {
            return {
                left: this.time,
            }
        },
        computed: {
            seconds() {
                if (this.left == 0)
                    this.endTime()
                return (this.left) % 60
            },
            minutes() {
                return Math.trunc(this.left / 60) % 60
            },
            hours() {
                return Math.trunc(this.left / 60 / 60) % 24
            },

        },
    }
</script>
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto+Condensed:400|Roboto:100);
    .text {
        color: #EF6C00;
        font-size: 20px;
        font-family: 'Roboto Condensed', serif;
        font-weight: 400;
        margin-bottom:0;
    }
    .digit {
        color: #3f51b5;
        font-size: 75px;
        font-weight: 100;
        font-family: 'Roboto', serif;
        margin-bottom:-20px;
    }
</style>