<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>  {{--//users.favoritesの　@include('users.card', ['user' => $user])　でusers.cardに飛ばされてきた--}}
    </div>
    <div class="card-body">
        <img class="rounded img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="">
    </div>
</div>
@include('user_follow.follow_button', ['user' => $user])



