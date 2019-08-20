<ul class="media-list">
    @foreach ($microposts as $micropost) {{--配列から変数が取り出される（=レコードは1つずつ取り出される）--}}

        <li class="media mb-3">
            <img class="mr-2 rounded" src="{{ Gravatar::src($micropost->user->email, 50) }}" alt="">    {{--//userはMicroposts.php--}}
            <div class="media-body">
                <div>
                    {!! link_to_route('users.show', $micropost->user->name, ['id' => $micropost->user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                </div>
                <div>
                    <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                    @foreach ($pictures->get() as $picture)
                    
                    
                    
                      @if($micropost->id == $picture->micropost_id)
                        <img src="/storage/{{$picture->img_path}}" />
                      @endif
                    @endforeach
                    
                    
                    
                    
                    
                </div>
                <div>
                {{-- 自分が投稿したpostの場合  --}}
                    @if (Auth::id() == $micropost->user_id)
                    
                {{--  deleteボタンを表示 --}}
                    {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
    
                {{-- 自分の投稿じゃない場合 --}}
                    @else
                    
                {{-- favarite されているならば unfavoriteボタンを表示--}}
                {{-- そうじゃないならfavoriteを表示--}}
                    @include('user_follow.favorites_button', ['user' => $user , 'micropost' => $micropost])



                   
                    
                    
                    
                    @endif
                    
                    
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $microposts->render('pagination::bootstrap-4') }}  {{--//ページ設定--}}