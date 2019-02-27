@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('news-create') }}
@endsection

@section('content')
    {!! Form::open(['route' => 'news.store', 'method' => 'POST']) !!}
    {{--Header--}}
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">Create a news</span>
                    <button type="submit" class="indigo waves-effect waves-light btn right tooltipped" data-tooltip="You sure? All data is correct?" data-position="top"><i class="material-icons right">send</i>Create news</button>
                    <a href="{{url('/news')}}" class="indigo waves-effect waves-light btn left m-r-10 tooltipped" data-tooltip="Information will be lost!" data-position="top"><i class="material-icons left">apps</i>Back to news</a>
                </div>
            </div>
        </div>
    </div>
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">title</i>
                    {!! Form::text('title', null, ['class' => 'validate', 'name' => 'title', 'id' => 'title', 'v-model' => 'title', 'required']) !!}
                    <label for="title">Title</label>
                </div>
                <widget-slug url="{{url('/')}}" subdirectory="/team/" :title="title"></widget-slug>
                <div class="input-field">
                    <textarea name="description"></textarea>
                </div>
            </div>
        </div>
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
                'insertdatetime table contextmenu paste code help wordcount',
                'link'
            ],
            toolbar: 'link insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
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
