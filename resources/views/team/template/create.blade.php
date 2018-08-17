@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-template-create') }}
@endsection
@section('content')
    {!! Form::open(['route' => 'team.template.store', 'method' => 'POST']) !!}
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">group</i>
                    {!! Form::text('display_name', null, ['class' => 'validate', 'name' => 'display_name', 'id' => 'display_name', 'v-model' => 'title', 'required']) !!}
                    <label for="display_name">Displaying Name</label>
                </div>
                <widget-slug url="{{url('/')}}" subdirectory="/team/template/" :title="title"></widget-slug>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">

        <button type="submit" class="btn-floating waves-effect waves-light btn-large green">
            <i class="large material-icons">add</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#slug',
            data: {
                title: ''
            }
        });
    </script>
@endsection
