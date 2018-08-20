@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-edit-homework-discipline-homework-edit', $team, $discipline->getDiscipline, $homeWork) }}
@endsection
@section('content')
    {!! Form::open(['route' => ['team.homework.update',$team->name,$discipline->getDiscipline->name,$homeWork->name], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    {{--Add Home Work--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">title</i>
                    {!! Form::text('display_name', $homeWork->getSolution()->display_name, ['class' => 'validate', 'name' => 'display_name', 'id' => 'display_name', 'required']) !!}
                    <label for="display_name">Display Name</label>
                </div>
                <div class="input-field">
                    <textarea name="description">{{$homeWork->getSolution()->description}}</textarea>
                </div>
                <div class="file-field">
                    <div class="btn indigo">
                        <span>File</span>
                        <input type="file" name="file[]" multiple>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload new files">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Send My Solution">
            <i class="large material-icons">save</i>
        </button>
        <ul>
            <li>
                <a class="btn-floating red tooltipped" data-position="left" data-tooltip="Go Back" href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/'.$homeWork->name)}}">
                    <i class="material-icons">close</i>
                </a>
            </li>
        </ul>
    </div>
    {!! Form::close() !!}
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
@endsection