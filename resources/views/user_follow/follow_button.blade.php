@if (Auth::id() != $user->id)    {{--//ログインユーザーとフォローしているユーザーが別人かどうかの確認をしている--}}
    @if (Auth::user()->is_following($user->id)) 　　　　 {{--//自分が他人をフォローしているかの確認をしている--}}
        {!! Form::open(['route' => ['user.unfollow', $user->id], 'method' => 'delete']) !!}    {{--//user.followに飛ばす　その際$user->idをuser.followに渡す--}}
            {!! Form::submit('Unfollow', ['class' => "btn btn-danger btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.follow', $user->id]]) !!}　　{{-- //user.followに飛ばす　その際$user-＞idをuser.followに渡す　　user.followはweb.phpで命名　--}}
            {!! Form::submit('Follow', ['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif
@endif