Hello, {{$name}}<br/><br/>
@if($changedAccess)
    Your {{$type}} access was activated.<br/>
@else
    Your {{$type}} was cancelled.<br/>
@endif
