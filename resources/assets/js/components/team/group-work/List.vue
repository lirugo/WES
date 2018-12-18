<template>
    <div>
        <div class="row">
            <div class="col s12">
                <div class="card-panel" v-for="work in sortedGroupWorks">
                    <span class="card-title">{{work.name}}</span>
                    <p>{{work.description}}</p>
                    <small><blockquote class="m-b-0 m-t-15">Start date - {{work.start_date}}</blockquote></small>
                    <small><blockquote class="m-b-0 m-t-5">End date - {{work.end_date}}</blockquote></small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Group work | list widget mounted.')
        },
        props: ['group_works'],
        watch: {
            group_works: function(newVal, oldVal) {
                this.group_works = newVal
            }
        },
        computed: {
            sortedGroupWorks() {
                return this.group_works.sort((a, b) => -(a.id - b.id))
            }
        },
    }
</script>