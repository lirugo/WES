@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline', $team, $discipline) }}
@endsection
@section('content')
    <div class="row" id="pretest">
        @foreach($pretests as $pretest)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content p-b-10 p-t-10">
                        <span class="card-title">{{$pretest->name}}</span>
                        <p class="m-b-10">{{$pretest->description}}</p>
                        @foreach($pretest->files as $file)
                            {!! Form::open(['route' => ['team.pretest.getFile', $file->file], 'method' => 'POST']) !!}
                            <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit" name="action">{{$file->name}}
                                <i class="material-icons right">file_download</i>
                            </button>
                            {!! Form::close() !!}
                        @endforeach
                        <small><blockquote class="m-b-0 m-t-15">Start date - {{$pretest->start_date}}</blockquote></small>
                        <small><blockquote class="m-b-0 m-t-5">End date - {{$pretest->end_date}}</blockquote></small>
                        @role('student')
                        <small><blockquote class="blockquote-green m-b-0 m-t-5">Passage time - {{$pretest->time}} min</blockquote></small>
                        @endrole
                    </div>
                    <div class="card-action right-align">
                        @role('student')
                        @if($pretest->isAvailable(Auth::user()->id))
                            <button @click="passPretest('{{$pretest->id}}')" class="indigo waves-effect waves-light btn-small right">Pass</button>
                        @else
                            <a class="waves-effect waves-light btn btn-small right disabled"><i class="material-icons right">lock</i>locked</a>
                        @endif
                        @endrole
                        @role('manager')
                            <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/statistic')}}" class="indigo waves-effect waves-light btn-small right">Statistic</a>
                        @endrole
                        @role('teacher')
                        <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id)}}" class="indigo waves-effect waves-light btn-small right">Open</a>
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach

        @role('teacher')
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
               data-tooltip="Create Pretest">
                <i class="large material-icons">add</i>
            </a>
        </div>
        @endrole
    </div>
    <!-- Modal Structure -->
    <div class="modal">
        <div class="modal-content">
            <h4>Attention</h4>
            <p>You are about to be tested.
                After the start of the test, it is impossible to stop or move the test.

                If you close the page, refresh it or go to another page - the test will be counted as passed, and you will receive points.

                If you are ready, click the "Ready" button.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="close()">Close</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="redirect()">Ready</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // TODO::// remake this it a trash
        var pretestId;
        var elem = document.querySelector('.modal');
        var instance = M.Modal.init(this.elem);
        function redirect() {
            window.location.href = '{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name)}}/'  + pretestId + '/pass';
        }

        new Vue({
            el: '#pretest',
            data: {
                elem: null,
                instance: null,
            },
            created() {
                this.elem = elem
                this.instance = instance
            },
            methods: {
                passPretest(id){
                    this.instance.open();
                    pretestId = id;
                },
            }
        })
    </script>
@endsection