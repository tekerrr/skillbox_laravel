<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="text-muted" href="#">Subscribe</a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="#">SkillBox Laravel</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="text-muted" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
                </a>

                <!-- Authentication Links -->
                @guest
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Войти</a>
                    <a class="ml-2 btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Регистрация</a>
                @else
                    <a id="navbarDropdown" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Выйти
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 text-muted" href="{{ route('posts.index') }}">Главная</a>
            <a class="p-2 text-muted" href="{{ route('news.index') }}">Новости</a>
            <a class="p-2 text-muted" href="{{ route('about') }}">О нас</a>
            <a class="p-2 text-muted" href="{{ route('contacts') }}">Контакты</a>
            <a class="p-2 text-muted" href="{{ route('posts.create') }}">Создать статью</a>
            <a class="p-2 text-muted" href="{{ route('admin.index') }}">Административный раздел</a>
        </nav>
    </div>

{{--    @include('layout.nav_extra')--}}

</div>
