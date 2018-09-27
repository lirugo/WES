@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('library-create') }}
@endsection
@section('content')
    {!! Form::open(['route' => 'library.store', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel">
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                    <label for="title">Title of Book</label>
                </div>
                <div class="input-field">
                    <textarea name="description">{!! old('description') !!}</textarea>
                </div>
                <div class="row m-b-0">
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">pages</i>
                        <input id="pages" name="pages" type="number" value="{{ old('pages') }}" min="10" max="100000" class="validate" required>
                        <label for="pages">Pages</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="year" name="year" type="number" value="{{ old('year') }}" min="1000" max="{{date('Y')}}" class="validate" required>
                        <label for="year">Year</label>
                    </div>
                </div>
                <input id="tags" name="tags" type="hidden">
                <div class="input-field  m-t-0">
                    <i class="material-icons prefix">visibility</i>
                    <div class="chips chips-placeholder chips-autocomplete m-t-0"></div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card hoverable" id="avatar">
                <div class="card-image">
                    <img :src="imgDataUrl">
                    <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" @click="toggleShow"><i class="material-icons">cloud_upload</i></a>
                </div>
                <input name="avatar" type="hidden" v-model="avatarName"/>
                <widget-avatar-cropper
                        field="avatar"
                        @crop-success="cropSuccess"
                        @crop-upload-success="cropUploadSuccess"
                        @crop-upload-fail="cropUploadFail"
                        v-model="show"
                        :width="300"
                        :height="400"
                        lang-type='en'
                        no-rotate
                        no-circle
                        url="/library/upload/image"
                        :params="params"
                        :headers="headers"
                        img-format="png">
                </widget-avatar-cropper>
                <div class="card-content p-t-0 p-b-0">
                    <div class="input-field">
                        <div class="file-field">
                            <div class="btn indigo">
                                <span>Book</span>
                                <input type="file" name="file" accept="application/pdf" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload only PDF">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Add Book">
            <i class="large material-icons">add</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        //Chips
        var optionsChip = {
            placeholder: 'Enter a tag',
            secondaryPlaceholder: '+ Tag',
            autocompleteOptions: {
                data: {
                }
            },
            onChipAdd: function (e, chip) {
                chip = chip.textContent.replace('close','');
                var data = optionsChip.autocompleteOptions.data;
                if(!data.hasOwnProperty(chip))
                    this.deleteChip(-1);

                var chips = document.getElementsByClassName('chip');
                var all = [];

                for(var i=0; i<chips.length; i++){
                    all.push(chips[i].firstChild.data);
                }

                document.getElementById('tags').value = JSON.stringify(all);
            }
        };
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('/tag/json')
                .then(response => {
                    optionsChip.autocompleteOptions.data = response.data;
                    var elems = document.querySelectorAll('.chips');
                    var instances = M.Chips.init(elems, optionsChip);
                });
        });
    </script>
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
            el: '#avatar',
            data: {
                show: false,
                params: {
                    name: 'avatar',
                },
                headers: {
                    'X-CSRF-Token': document.head.querySelector("[name=csrf-token]").content
                },
                imgDataUrl: '/images/book.jpg',
                avatarName: ''
            },
            methods: {
                toggleShow() {
                    this.show = !this.show;
                },
                /**
                 * crop success
                 *
                 * [param] imgDataUrl
                 * [param] field
                 */
                cropSuccess(imgDataUrl, field){
                    console.log('-------- crop success --------');
                    this.imgDataUrl = imgDataUrl;
                },
                /**
                 * upload success
                 *
                 * [param] jsonData  server api return data, already json encode
                 * [param] field
                 */
                cropUploadSuccess(jsonData, field){
                    console.log('-------- upload success --------');
                    this.avatarName = jsonData.avatar;
                },
                /**
                 * upload fail
                 *
                 * [param] status    server api return error status, like 500
                 * [param] field
                 */
                cropUploadFail(status, field){
                    console.log('-------- upload fail --------');
                    console.log(status);
                    console.log('field: ' + field);
                }
            }
        });
    </script>
@endsection
