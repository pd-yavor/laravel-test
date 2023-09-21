Hello, {{$name}}<br/><br/>
@if($wasCreated)
    After your first order, we have created an account for you. You can login with your email address and the password: <b>{{$password}}</b>.<br/>
@endif
Your order has been shipped.<br/>
Credit card: **** **** **** {{$lastfour}}<br/>
