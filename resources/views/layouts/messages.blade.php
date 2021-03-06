@if(session('success') OR isset($success))
    <div class="message is-success">
        <div class="message-body">
        <ul>
            <li>{{ session('success') ? session('success') : $success }}</li>
        </ul>
        </div>
    </div>
@endif

@if(session('danger') OR isset($danger))
    <div class="message is-danger">
        <div class="message-body">
        <ul>
            <li>{{ session('danger') ? session('danger') : $danger }}</li>
        </ul>
        </div>
    </div>
@endif
