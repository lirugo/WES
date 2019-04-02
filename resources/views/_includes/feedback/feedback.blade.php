<!-- Modal Structure -->
<div class="feedback-modal modal">
    {!! Form::open(['route' => ['feedback.send'], 'method' => 'POST']) !!}
    <div class="modal-content">
        <h4 class="center-align">@lang('app.Feedback')</h4>
        <p class="center-align">
            @lang('app.We’ll be very grateful to know about problems in the work of the educational platform!')
        </p>
        <div class="input-field col s12">
            <input placeholder="@lang('app.Write title here')" id="title" name="title" type="text" class="validate" required>
            <label for="title">@lang('app.Title')</label>
        </div>
        <div class="input-field col s12">
            <textarea id="body" placeholder="@lang('app.Write body here')" name="body" class="materialize-textarea" required></textarea>
            <label for="body">@lang('app.Body')</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">@lang('app.Close')</a>
        <button type="submit" class="waves-effect waves-green btn-flat">@lang('app.Send')</button>
    </div>
    {!! Form::close() !!}
</div>