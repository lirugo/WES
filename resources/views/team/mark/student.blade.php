@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark-student', $team, $student) }}
@endsection
@section('content')
    <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    student
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#log',
            methods: {
                update: function (mark){
                    console.log(mark);
                }
            }
        })
    </script>
@endsection
