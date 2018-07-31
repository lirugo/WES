@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'team.store', 'method' => 'POST']) !!}
    {{--Header--}}
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">Create a new group</span>
                    <button type="submit" class="indigo waves-effect waves-light btn right tooltipped" data-tooltip="You sure? All data is correct?" data-position="top"><i class="material-icons right">send</i>Create a new group</button>
                    <a href="{{url('/manage')}}" class="indigo waves-effect waves-light btn left m-r-10 tooltipped" data-tooltip="Information will be lost!" data-position="top"><i class="material-icons left">apps</i>Back to manage</a>
                </div>
            </div>
        </div>
    </div>
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">group</i>
                    <input placeholder="Displaying Name" id="display_name" name="display_name" type="text" class="validate" v-model="title">
                    <label for="display_name">Displaying Name</label>
                </div>
                <widget-slug url="{{url('/')}}" subdirectory="/team/" :title="title"></widget-slug>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    {!! Form::textarea('description', null, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required']) !!}
                    <label for="description">Description</label>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                title: ''
            }
        });
    </script>
@endsection
