@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                @include('users.card', ['user' => Auth::user()])
            </aside>
            <div class="col-sm-8">
             @include('users.navtabs' , ['user' => Auth::user()])
             
                @if (Auth::id() == $user->id)
            
                    {!! Form::open(['route' => 'microposts.store' , 'files' => true]) !!}    {{--送信内容はMicropostsController.phpの@storeへ--}}
                        <div class="form-group">
                            {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}  {{--文字を保存ときにcontentというデータになる。ポストした内容は、$requestの中にあるcontentという変数に入って、mcropostcontrollerに送られる。--}}
                            {!! Form::file('image', null) !!}
                            {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                    {!! Form::close() !!}
                @endif
                @if (count($microposts) > 0)
                    @include('microposts.microposts', ['microposts' => $microposts , 'pictures' => $pictures])  {{--microposts.bladeの情報を取得する　+　$micropostsと$picturesの情報をmicroposts.bladeに渡す--}}
                @endif
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Microposts</h1>
                
                
                
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection