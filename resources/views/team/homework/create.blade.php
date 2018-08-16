@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-edit-homework-discipline-create', $team, $discipline->getDiscipline) }}
@endsection
@section('content')
    {{--Add Home Work--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                {!! Form::open(['route' => ['team.homework.store',$team->name,$discipline->getDiscipline->name], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
                    <div class="input-field m-b-0">
                        <i class="material-icons prefix">title</i>
                        {!! Form::text('display_name', null, ['class' => 'validate', 'name' => 'display_name', 'id' => 'display_name', 'v-model' => 'title', 'required']) !!}
                        <label for="display_name">Display Name</label>
                    </div>
                    <widget-slug url="{{url('/')}}" subdirectory="/team/{{$team->name}}/homework/{{$discipline->getDiscipline->name}}/" :title="title"></widget-slug>
                    <div class="input-field">
                        <textarea name="description"></textarea>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <div class="file-field">
                            <div class="btn indigo">
                                <span>File</span>
                                <input type="file" name="file[]" required multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload files">
                            </div>
                        </div>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="text" class="datepickerDefault" required>
                        <label for="end_date">End Date Assignment</label>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">access_time</i>
                        <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text" class="timepicker" required>
                        <label for="end_time">End Time Assignment</label>
                    </div>
                    <button class="btn waves-effect waves-light indigo" type="submit">Set Home Work
                        <i class="material-icons right">send</i>
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey={{env('TINY_MC_KEY')}}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime table contextmenu paste code help wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css']
        });
    </script>
    <script>
        new Vue({
            el: '#slug',
            data: {
                title: ''
            }
        });
    </script>
@endsection
