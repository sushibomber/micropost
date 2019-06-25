
    @if (Auth::user()->add_favorites($micropost->id)) {{--//自分（ログインユーザー）がmicropostのidをお気に入りにしているかの確認--}}

        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}    {{--//favorites.unfavoriteに飛ばす　その際$microposts->idをfavorites.unfavoriteに渡す--}}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-sm"]) !!}    {{--//unfavoriteはUser.phpで定義している--}}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['favorites.favorite', $micropost->id] , 'method' => 'post' ]) !!}　　{{-- //favorites.favoriteに飛ばす　その際$microposts->idをfavorites.favoriteに渡す　　favorites.favoriteはweb.phpで命名　favorite機能はユーザーidではなくmicropstidに対しfavoriteする　--}}
            {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-sm"]) !!}　　　　{{--//favoriteはUser.phpで定義している--}}
        {!! Form::close() !!}
    @endif
