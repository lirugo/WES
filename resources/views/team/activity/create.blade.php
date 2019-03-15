@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity-create', $team) }}
@endsection
@section('content')
    <div class="row m-b-0" id="activity-create-form">
        <div class="progress m-t-0 red" v-if="isUploading">
            <div class="indeterminate orange"></div>
        </div>
        <div class="col s12 m6">
            <div class="card-panel">
                {!! Form::open(['route' => ['team.activity.store', $team->name]]) !!}
                <div class="row m-b-0">
                    <div class="input-field col s12">
                        <input id="name" name="name" type="text" class="validate" required>
                        <label for="name">Name</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="description" name="description" class="materialize-textarea" required></textarea>
                    </div>
                    <div class="input-field col s12" v-if="other" >
                        <input id="type_name" name="type_name" type="text" class="validate" required>
                        <label for="type_name">Other type</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select name="type" required v-model="type">
                            <option value="" disabled>Type of Activity</option>
                            @foreach (config('activity') as $key => $name)
                                <option value="{{ $key }}"{{ old('type') == $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{--Discipline--}}
                    <div class="input-field col s12 m6">
                        <select name="discipline_id" required>
                            <option value="" disabled>Choose a discipline</option>
                            @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m6 m-b-15">
                        <input disabled/>
                        <label>
                            <input type="checkbox" name="mark_in_journal" @click="mark_in_journal ? mark_in_journal=false : mark_in_journal=true" />
                            <span>Mark in Journal</span>
                        </label>
                    </div>
                    <div class="input-field col s12 m6" v-if="mark_in_journal">
                        <input id="max_mark" name="max_mark" type="number" min="1" max="50" class="validate" required>
                        <label for="max_mark">Max Mark</label>
                    </div>
                </div>
                <div class="row m-b-0">
                    {{--Start date&time picker--}}
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="text" class="datepickerDefault" required>
                        <label for="start_date">Start date</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">access_time</i>
                        <input id="start_time" value="{{ old('start_time') }}" name="start_time" type="text" class="timepicker" required>
                        <label for="start_time">Start Time</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="text" class="datepickerDefault" required>
                        <label for="end_date">End date</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">access_time</i>
                        <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text" class="timepicker" required>
                        <label for="end_time">End Time</label>
                    </div>
                </div>

                <div class="fixed-action-btn" id="activity-create">
                    <button type="submit" class="btn-floating btn-large waves-effect waves-light green"><i class="material-icons">save</i></button>
                </div>
                <input type="hidden" name="inputs" v-model="JSON.stringify(inputs)" />
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card-panel">
                <h6 class="center-align">Upload Education Materials</h6>
                <div class="row m-b-0" v-for="(input, index) in inputs">
                    <div class="input-field col s10 m-b-0">
                        <i class="material-icons prefix">attachment</i>
                        <input placeholder="Write name of education material" name="file" id="file" type="text"
                               v-model="input.file" class="validate" required>
                    </div>
                    <div class="input-field col s2">
                        <a href="#" @click="deleteRow(index)"><i class="material-icons prefix center-align icon-red">delete</i></a>
                    </div>
                    <div class="col s12 file-field input-field">
                        <div class="btn indigo">
                            <span>File</span>
                            <input type="file" :id="'upload-'+index" required>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" placeholder="Upload file" @change="uploadFile(index)"
                                   type="text">
                        </div>
                    </div>
                </div>
                <a class="btn-floating btn-large waves-effect waves-light red left" @click="addRow"><i
                            class="material-icons">add</i></a>
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
                'insertdatetime table contextmenu paste code help wordcount',
                'link'
            ],
            toolbar: 'link insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat ',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css']
        });
    </script>
    <script>
        new Vue({
            el: '#activity-create-form',
            data: {
                other: false,
                type: String,
                mark_in_journal: false,
                links: [],
                inputs: [
                    {
                        file: null,
                        nameFormServer: null
                    }
                ],
                isUploading: false
            },
            watch: {
                type(){
                    if(this.type == 'other')
                        this.other = true
                    else
                        this.other = false

                },
            },
            methods: {
                addRow() {
                    this.inputs.push({
                        file: null,
                        nameFormServer: null
                    })
                },
                deleteRow(index) {
                    this.inputs.splice(index, 1)
                },
                uploadFile(index) {
                    let formData = new FormData()
                    this.isUploading = true
                    const parent = this;
                    formData.append('file', document.getElementById('upload-' + index).files[0]);
                    axios.post('/team/{!! $team->name !!}/activity/store/file', formData,
                    ).then(function (response) {
                        parent.inputs[index].nameFormServer = response.data
                        parent.isUploading = false
                    })
                        .catch(function () {
                            console.log('FAILURE!!');
                        });
                }
            }
        })
    </script>
@endsection
