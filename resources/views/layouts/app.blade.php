<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="md:flex">
        <nav class="bg-white border-r-2 border-grey-lighter shadow collapsed w-full md:w-16 md:min-h-screen">
            <a href="{{ route('home') }}" class="px-4 pt-4 md:py-4 block text-center md:mb-8 mb-2">
                <img src="/img/logo.svg" alt="" class="" width="26">
            </a>
            <ul class="md:py-4 list-reset">
                <li class="text-grey-dark hover:bg-grey-lightest hover:text-green-light hover:border-r-4 hover:border-green-light">
                    <a href="{{ route('home') }}" class="link-reset text-center block py-4 px-4">
                        <span class="">
                            <i class="fa fas fa-th-large"></i>
                        </span>
                    </a>
                </li>
                <li class="text-grey-dark hover:bg-grey-lightest hover:text-green-light hover:border-r-4 hover:border-green-light">
                    <a href="{{ route('servers.create') }}" class="link-reset text-center block py-4 px-4">
                        <span class="">
                            <i class="fa fas fa-server"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
        <main class="bg-ghost-white min-h-screen w-full relative pt-hero">
            <header class="bg-white border-b-2 border-grey-lighter shadow-sm fixed z-40 pin-r pin-t" style="width: calc(100% - 61px;">
                <nav class="md:flex justify-between items-center">
                    <div class="flex">
                        <div class="flex">
                            <a href="#" class="text-grey hover:bg-grey-lightest hover:text-green-light px-4 py-6 border-r border-grey-lighter hover:border-green-light">
                                <span class="border-l-2">
                                    <i class="fa fa-arrow-right"></i>
                                </span>
                            </a>
                        </div>
                        <form action="#" class="">
                            <div class="flex px-4 py-6 text-grey">
                                <span class="inline-block mr-2">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input class="appearance-none bg-transparent w-64 outline-none text-grey font-sans font-light" type="search" placeholder="Recherche une transaction...">
                            </div>
                        </form>
                    </div>
                    <div class="flex md:flex-row flex-col">
                        <a href="#" class="text-grey hover:bg-grey-lightest hover:text-green-light px-6 py-6 border-l border-r border-grey-lighter hover:border-green-light text-center">
                            <span class="">
                                <i class="fa fa-question"></i>
                            </span>
                        </a>
                        <a href="#" class="text-grey hover:bg-grey-lightest hover:text-green-light px-6 py-6 border-l border-r border-grey-lighter hover:border-green-light text-center">
                            <span class="">
                                <i class="fa fa-cog"></i>
                            </span>
                        </a>
                        <a href="#" class="text-grey hover:bg-grey-lightest hover:text-green-light px-6 py-6 border-l border-r border-grey-lighter hover:border-green-light text-center">
                            <span class="">
                                <i class="far fa-bell"></i>
                            </span>
                        </a>

                        <a href="#" class="text-grey hover:bg-grey-lightest hover:text-green-light px-6 py-4 border-grey-lighter hover:border-green-light no-underline justify-center items-center flex relative text-center">
                            <img src="/img/pharmacy.svg" alt="" class="border rounded-full border-grey-dark inline-block mr-2">
                            <span class="">{{auth()->user()->name}}</span>
                            {{-- <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                              </div> --}}
                        </a>
                        <a href="#" class="text-grey hover:bg-grey-lightest hover:text-green-light px-6 py-6 border-l border-r border-grey-lighter hover:border-green-light text-center" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <span class="">
                                <i class="fa fa-power-off"></i>
                            </span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </nav>
            </header>
            @yield("content")
        </main>
    </div>
</body>
</html>
