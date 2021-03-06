@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-create', $team) }}
@endsection
@section('content')
    <div id="pretest-files">
        <div class="progress m-t-0 red" v-if="isUploading">
            <div class="indeterminate orange"></div>
        </div>
        {!! Form::open(['route' => ['team.pretest.store', $team->name], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
            <div class="col s12 l6">
                <div class="card-panel">
                    <div class="row m-b-0">
                        <div class="input-field col s12 m8">
                            <select name="discipline_id" required>
                                <option value="" disabled>@lang('app.Choose a discipline')</option>
                                @role('teacher')
                                @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                    <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                                @endforeach
                                @endrole
                                @role('manager')
                                @foreach($team->disciplines as $discipline)
                                    <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                                @endforeach
                                @endrole
                            </select>
                        </div>
                        <div class="input-field col s12 m4">
                            {!! Form::number('time', null, ['placeholder' => trans('app.Minutes'), 'min' => 0, 'max' => 480, 'required']) !!}
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">title</i>
                        <input placeholder="@lang('app.Write name of pretest')" name="name" id="name" type="text" class="validate"
                               required>
                        <label for="name">@lang('app.Name')</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">format_align_justify</i>
                        <textarea placeholder="Write description of pretest" name="description" id="description" type="text"
                                  class="validate materialize-textarea" required></textarea>
                        <label for="description">@lang('app.Description')</label>
                    </div>
                    <div class="row">
                        {{--Start date&time picker--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="text"
                                   class="datepickerDefault" required>
                            <label for="start_date">@lang('app.Start date')</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">access_time</i>
                            <input id="start_time" value="{{ old('start_time') }}" name="start_time" type="text"
                                   class="timepicker" required>
                            <label for="start_time">@lang('app.Start Time')</label>
                        </div>
                        {{--End date&time picker--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="text"
                                   class="datepickerDefault" required>
                            <label for="end_date">@lang('app.End date')</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">access_time</i>
                            <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text"
                                   class="timepicker" required>
                            <label for="end_time">@lang('app.End Time')</label>
                        </div>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="mark_in_journal"/>
                            <span>@lang('app.Mark in Journal')</span>
                        </label>
                    </p>
                </div>
            </div>
            <div class="col s12 l6">
                <div class="card-panel">
                    <h6 class="center-align">@lang('app.Upload Education Materials')</h6>
                    <div class="row m-b-0" v-for="(input, index) in inputs">
                        <div class="input-field col s10 m-b-0">
                            <i class="material-icons prefix">attachment</i>
                            <input placeholder="@lang('app.Write name of education material')" name="file" id="file" type="text"
                                   v-model="input.file" class="validate" required>
                        </div>
                        <div class="input-field col s2">
                            <a href="#" @click="deleteRow(index)"><i class="material-icons prefix center-align icon-red">delete</i></a>
                        </div>
                        <div class="col s12 file-field input-field">
                            <div class="btn indigo">
                                <span>@lang('app.File')</span>
                                <input type="file" :id="'upload-'+index" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" placeholder="@lang('app.Upload file')" @change="uploadFile(index)"
                                       type="text">
                            </div>
                        </div>
                        <input type="hidden" name="inputs" v-model="JSON.stringify(inputs)" />
                    </div>
                    <a class="btn-floating btn-large waves-effect waves-light red left" @click="addRow"><i
                                class="material-icons">add</i></a>
                </div>
            </div>
        </div>
        @role(['manager', 'teacher'])
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <button type="submit" class="btn-floating btn-large green tooltipped"
                    data-position="left"
                    data-tooltip="@lang('app.Save')">
                <i class="large material-icons">save</i>
            </button>
        </div>
        @endrole
        {!! Form::close() !!}
    </div>
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
                    axios.post('/team/{!! $team->name !!}/pretest/store/file', formData,
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
