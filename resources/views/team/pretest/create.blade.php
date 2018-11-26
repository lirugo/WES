@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-create', $team) }}
@endsection
@section('content')
    {!! Form::open(['route' => ['team.pretest.store', $team->name], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="col s12 l6">
            <div class="card-panel">
                <div class="row m-b-0">
                    <div class="input-field col s12 m8">
                        <select name="discipline_id" required>
                            <option value="" disabled>Choose a discipline</option>
                            @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m4">
                        {!! Form::number('time', null, ['placeholder' => 'Minutes', 'min' => 0, 'max' => 480, 'required']) !!}
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input placeholder="Write name of pretest" name="name" id="name" type="text" class="validate"
                           required>
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    <textarea placeholder="Write description of pretest" name="description" id="description" type="text"
                              class="validate materialize-textarea" required></textarea>
                    <label for="description">Description</label>
                </div>
                <div class="row">
                    {{--Start date&time picker--}}
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="text"
                               class="datepickerDefault" required>
                        <label for="start_date">Start date</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">access_time</i>
                        <input id="start_time" value="{{ old('start_time') }}" name="start_time" type="text"
                               class="timepicker" required>
                        <label for="start_time">Start Time</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="text"
                               class="datepickerDefault" required>
                        <label for="end_date">End date</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">access_time</i>
                        <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text"
                               class="timepicker" required>
                        <label for="end_time">End Time</label>
                    </div>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="mark_in_journal"/>
                        <span>Mark in Journal</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="col s12 l6" id="pretest-files">
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
                            <input type="file" id="uploadFile" required>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" placeholder="Upload file" @change="uploadFile(index)"
                                   type="text">
                        </div>
                    </div>
                    <input type="hidden" name="nameFormServer" v-model="inputs[0].nameFormServer" />
                </div>
                <a class="btn-floating btn-large waves-effect waves-light red left" @click="addRow"><i
                            class="material-icons">add</i></a>
            </div>
        </div>
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped"
                data-position="left"
                data-tooltip="Save">
            <i class="large material-icons">save</i>
        </button>
    </div>
    @endrole
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#pretest-files',
            data: {
                inputs: [
                    {
                        file: null,
                        nameFormServer: null
                    }
                ]
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
                    console.log('Uploading...')
                    let formData = new FormData();
                    var inputs = this.inputs;
                    formData.append('file', document.getElementById('uploadFile').files[0]);
                    axios.post('/team/{!! $team->name !!}/pretest/store/file', formData,
                    ).then(function (response) {
                        inputs[index].nameFormServer = response.data
                    })
                        .catch(function () {
                            console.log('FAILURE!!');
                        });
                    this.inputs = inputs;
                }
            }
        })
    </script>
@endsection
