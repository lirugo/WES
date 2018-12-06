@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-create', $team) }}
@endsection
@section('content')
    <div id="material-files">
        <div class="progress m-t-0 red" v-if="isUploading">
            <div class="indeterminate orange"></div>
        </div>
        {!! Form::open(['route' => ['team.material.store', $team->name], 'method' => 'POST']) !!}
        <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
            <div class="col s12 l6">
                <div class="card-panel">
                    <h6 class="center-align">Upload Education Materials</h6>
                    <div class="input-field col s12">
                        <select name="discipline_id" required>
                            <option value="" disabled>Choose a discipline</option>
                            @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row m-b-0" v-for="(input, index) in inputs">
                        <div class="input-field col s12 m-b-0">
                            <i class="material-icons prefix">attachment</i>
                            <input placeholder="Write name of education material" name="file" id="file" type="text"
                                   v-model="input.file" class="validate" required>
                        </div>
                        {{--<div class="input-field col s2">--}}
                            {{--<a href="#" @click="deleteRow(index)"><i class="material-icons prefix center-align icon-red">delete</i></a>--}}
                        {{--</div>--}}
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
                        <input type="hidden" name="inputs" v-model="JSON.stringify(inputs)" />
                    </div>
                    {{--<a class="btn-floating btn-large waves-effect waves-light red left" @click="addRow"><i--}}
                                {{--class="material-icons">add</i></a>--}}
                </div>
            </div>
        </div>
        @if(Auth::user()->hasRole('teacher'))
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <button type="submit" class="btn-floating btn-large green tooltipped"
                    data-position="left"
                    data-tooltip="Save">
                <i class="large material-icons">save</i>
            </button>
        </div>
        @endif
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#material-files',
            data: {
                inputs: [
                    {
                        file: null,
                        nameFormServer: null
                    }
                ],
                isUploading: false
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
                    axios.post('/team/{!! $team->name !!}/material/store/file', formData,
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
