@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            @include('users.card', ['user' => $user])  {{--//users.cardをfavorites.bladeにincludeする　users.cardに変数$userの値をuserというキーにして渡す　尚、users.cardではキーuserではなく変数$userとして記述する--}}
        </aside>
        <div class="col-sm-8">
            
            
            
            @include('users.navtabs', ['user' => $user])
            
            @if (count($microposts) > 0)
                @include('microposts.microposts', ['microposts' => $microposts])
            @endif
            
            
            
            
        </div>
    </div>
@endsection