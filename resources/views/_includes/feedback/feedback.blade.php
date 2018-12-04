<!-- Modal Structure -->
<div class="feedback-modal modal">
    {!! Form::open(['route' => ['feedback.send'], 'method' => 'POST']) !!}
    <div class="modal-content">
        <h4 class="center-align">Feedback</h4>
        <p class="center-align">
            We’ll be very grateful to know about problems in the work of the educational platform!
        </p>
        <div class="input-field col s12">
            <input placeholder="Write title here" id="title" name="title" type="text" class="validate" required>
            <label for="title">Title</label>
        </div>
        <div class="input-field col s12">
            <textarea id="body" placeholder="Write body here" name="body" class="materialize-textarea" required></textarea>
            <label for="body">Body</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        <button type="submit" class="waves-effect waves-green btn-flat">Send</button>
    </div>
    {!! Form::close() !!}
</div>