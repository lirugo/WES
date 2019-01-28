@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-create') }}
@endsection
@section('content')
    {!! Form::open(['route' => 'team.store', 'method' => 'POST']) !!}
    {{--Name and General block--}}
    <div class="row" id="team-create">
        <div class="col s12">
            <div class="card-panel hoverable">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">group</i>
                    {!! Form::text('display_name', null, ['class' => 'validate', 'name' => 'display_name', 'id' => 'display_name', 'v-model' => 'title', 'required']) !!}
                    <label for="display_name">Displaying Name</label>
                </div>
                <widget-slug url="{{url('/')}}" subdirectory="/team/" :title="title"></widget-slug>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    {!! Form::textarea('description', null, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required']) !!}
                    <label for="description">Description</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">assignment</i>
                    <select name="template" v-model="template" required>
                        <option value="" disabled selected>Choose template for Group</option>
                        @foreach($templates as $template)
                            <option value="{{$template->name}}">{{$template->display_name}}</option>
                        @endforeach
                    </select>
                    <label>Group Template</label>
                </div>
            </div>
        </div>
        {{--Add lesson time--}}
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <p class="flow-text m-t-0 m-b-0">
                    Set lessons time
                </p>
                <div class="row">
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="startTime_1" required>
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 1</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="endTime_1" required>
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 1</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="startTime_2" required>
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 2</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="endTime_2" required>
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 2</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="startTime_3" required>
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 3</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="endTime_3" required>
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 3</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="startTime_4">
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 4</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="End time" name="endTime_4">
                        <span class="helper-text" data-error="wrong" data-success="right">Lesson 4</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Create Group">
            <i class="large material-icons">add</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#team-create',
            data: {
                template: '',
                title: '',
            },
            methods: {
            }
        });
    </script>
@endsection
