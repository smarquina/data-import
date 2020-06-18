<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">
            {{ config('app.name', 'Data import') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('product.index')}}">{{__('general.menu.products')}}</a>
                </li>

                <li class="nav-item dropdown">
                    <a id="langDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('general.menu.lang') }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="langDropdown">
                        @foreach(\App\Http\Models\Translate\Translation::availableLangs() as $code => $lang)
                            <a class="dropdown-item" href="#" data-lang="{{$code}}">{{ $lang }}</a>
                        @endforeach
                        <form id="set-lang-form" action="{{ route('setLang') }}" method="POST" style="display: none;">
                            <input type="hidden" name="language" value="">
                            @csrf
                        </form>
                    </div>
                </li>


                <!-- Authentication Links -->
                @guest
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
                    {{--                    </li>--}}
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


<script type="text/javascript">
    (function (window, document) {
        window.onload = () => {
            document.querySelectorAll("a[data-lang]").forEach(anchor => {
                anchor.addEventListener('click', event => {
                    event.preventDefault();
                    const lang = event.target.getAttribute('data-lang');
                    const form = document.querySelector("#set-lang-form");
                    form.querySelector("input[name=language]").value = lang;
                    form.submit();
                }, false)
            });
        }
    })(window, document);
</script>
