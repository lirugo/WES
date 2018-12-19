@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-group-work-show', $team, $discipline) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div id="group-work">
        {{--Create--}}
        <group-work-create
            :save_work="saveWork"></group-work-create>

        {{--Display--}}
        <group-work-list
            :group_works="groupWorks"></group-work-list>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el:'#group-work',
            data: {
                groupWorks: []
            },
            created() {
                axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/getGroupWorks')
                    .then(response => {
                        this.groupWorks = response.data
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            methods:{
                saveWork(groupWork){
                    axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/store', groupWork)
                        .then(response => {
                            this.groupWorks.push(response.data)
                            console.log(response.data)
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                }
            }
        })
    </script>
@endsection
