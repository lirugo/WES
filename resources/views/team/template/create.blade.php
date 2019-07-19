@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-template-create') }}
@endsection
@section('content')
    {!! Form::open(['route' => 'team.template.store', 'method' => 'POST']) !!}
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">group</i>
                    {!! Form::text('display_name', null, ['class' => 'validate', 'name' => 'display_name', 'id' => 'display_name', 'v-model' => 'title', 'required']) !!}
                    <label for="display_name">@lang('app.Displaying Name')</label>
                </div>
                <widget-slug url="{{url('/')}}" subdirectory="/team/template/" :title="title"></widget-slug>
            </div>
        </div>
        {{--Add lesson time--}}
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <p class="flow-text m-t-0 m-b-0">
                    @lang('app.Set lessons time')
                </p>
                <div class="row">
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="startTime_1" value="9:30" required>
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 1</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="endTime_1" value="12:45" required>
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 1</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="startTime_2" value="13:30" required>
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 2</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="endTime_2" value="16:45" required>
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 2</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="startTime_3" value="17:00" required>
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 3</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="endTime_3" value="20:15" required>
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 3</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="startTime_4">
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 4</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" class="timepicker" placeholder="@lang('app.End time')" name="endTime_4">
                        <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') 4</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">

        <button type="submit" class="btn-floating waves-effect waves-light btn-large green">
            <i class="large material-icons">add</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#slug',
            data: {
                title: ''
            }
        });
    </script>
@endsection
