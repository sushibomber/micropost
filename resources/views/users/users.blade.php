@if (count($users) > 0)
    <ul class="list-unstyled">
        @foreach ($users as $user)    {{--//$usersには、自分をフォローしてくれた人・自分がフォローした人の一覧が情報として入っている　--}}
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                        <p>{!! link_to_route('users.show', 'View profile', ['id' => $user->id]) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $users->render('pagination::bootstrap-4') }}
@endif