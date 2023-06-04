<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

</head>
<body>
    <div id="app">
        <nav class="navbar  navbar-light bg-white shadow-sm ">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('tasks.index') }}">
                    {{ config('app.name', 'Laravel') }}

                </a>Пароль для проверки:   7Ddf5VUgxF8uQc
                @if(isset($list_name))
                <form class="d-flex" role="search" method="post" action="{{route('list.find', $list_name->id)}}">
                    @csrf
                    <div style="margin-right: 10px ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="search" id="option1" value="{{1}}" >
                            <label class="form-check-label" for="option1">
                                По тегам
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="search" id="option2" value="{{2}}" >
                            <label class="form-check-label" for="option2">
                                По названию
                            </label>
                        </div>
                    </div>

                    <input class="form-control me-2" type="search" name="name" placeholder="Поиск задачи в списке" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Поиск</button>
                </form>
                @endif
                <ul>
                    @guest
                        @if (Route::has('login'))
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </div>
                        @endif

                        @if (Route::has('register'))
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        @endif
                    @else
                        <div style="display: table">
                            <div class="nav-item dropdown" style="display: table-cell; padding-right:70px">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Списки</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form  id="create_list" class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="New List" aria-label="New List" aria-describedby="basic-addon1">
                                            <button type="submit" class="input-group-text" id="basic-addon1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" style="margin-top: 50px">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="{{route('tasks.index')}}">Все списки</a>
                                        </li>
                                        <h4>Lists:</h4>
                                        <div style="margin-left: 20px">
                                            @foreach($lists as $list)
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{route('list.show', ['userId' => $list->user_id, 'list' => $list->id])}}">{{$list->name}}</a>
                                                </li>
                                            @endforeach
                                        </div>
                                    </ul>
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" style="margin-top: 50px">
                                        @isset($availableLists)
                                            <h4>Списки которые вам доступны:</h4>
                                            <div style="margin-left: 20px">
                                                @foreach($availableLists as $availableList)
                                                    <div>
                                                        <a href="{{route('list.show', ['userId' => $availableList->user_id, 'list' => $availableList->id])}}" style="text-decoration: none; color: green;">
                                                            {{$availableList->name}}
                                                        </a>
                                                    </div>

                                                @endforeach
                                            </div>
                                        @endisset
                                        <form action="{{route('list.share')}}" method="post">
                                            @csrf
                                            <input style="margin-top: 20px" class="form-control" name="user_email" type="text" placeholder="Введите почту пользователя" aria-label="default input example" required>
                                            <select style="margin-top: 20px" name="list_id[]"  class="form-select" multiple aria-label="multiple select example">
                                                <option value="{{'-1'}}">Все списки</option>
                                                @foreach($lists as $list)
                                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" style="margin-top: 20px" class="btn btn-primary">Дать доступ</button>
                                        </form>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

                        <script>

                            $('#create_list').on('submit',function(event){
                                event.preventDefault();

                                let name = $('#name').val();

                                $.ajax({
                                    url: "{{route('list.store')}}",
                                    type:"POST",
                                    data:{
                                        "_token": "{{ csrf_token() }}",
                                        name:name,
                                    },
                                    success:function(response){
                                        console.log('complete');
                                    },
                                });
                            });
                        </script>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

