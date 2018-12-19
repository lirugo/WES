<template>
    <div class="row">
        <div v-for="work in sortedGroupWorks">
            <group-work-row
                    :work="work"
                    :team_name="team_name"
                    :discipline_name="discipline_name"
            ></group-work-row>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Group work | list widget mounted.')
        },
        props: ['group_works', 'team_name', 'discipline_name'],
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