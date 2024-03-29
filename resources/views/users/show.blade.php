@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            @include('users.card', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            @include('users.navtabs', ['user' => $user])
            
            @if (Auth::id() == $user->id)  {{--//ログインidと$userが一緒だったらpost欄が出てくる仕様　他人のprofileでは表示されない--}}
                {!! Form::open(['route' => 'microposts.store', 'files' => true ]) !!}
                    <div class="form-group">
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
                        {!! Form::file('image', null) !!}
                        
                        
                        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                
                    </div>
                {!! Form::close() !!}
            @endif
            @if (count($microposts) > 0)
                @include('microposts.microposts', ['microposts' => $microposts])
            @endif
        </div>
    </div>
@endsection