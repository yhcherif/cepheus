@extends('layouts.auth')

@section('content')
<div class="container-lg bg-white h-screen flex">
    <div class="bg-white pt-4 md:p-8 w-full md:w-2/5 h-full bg-white flex flex-col items-center justify-center relative">
        @if(session("status"))
            <div class="bg-teal-lightest border-t-4 border-teal rounded-b text-teal-darkest px-4 py-3 shadow-md absolute pin-t pin-l mt-6 ml-6" role="alert">
              <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                  <p class="font-bold">Hey!</p>
                  <p class="text-sm">{{session("status")}}</p>
                </div>
              </div>
            </div>
        @endif
        <h1 class="mt-6 text-white mb-8">
            <a href="{{ url('/') }}" class="link-reset text-center block">
                <img src="/img/logo_white.svg" alt="{{config('app.name')}}" class="">
                <p class="uppercase text-center text-midnight font-light mt-1">
                    CEPHEUS
                </p>
            </a>
        </h1>
        <div class="md:py-4 w-full px-8">
            <form method="POST" action="{{ route('login') }}" class="w-full px-4">
                @csrf
                <div class="mb-6">
                    <label for="email" class="cursor-pointer border-b px-4 py-2 text-midnight flex items-center mb-1 {{ $errors->has('email') ? ' border-red' : 'border-midnight' }}">
                        <span class="mr-4 mb-1">
                            <i class="fas fa fa-envelope"></i>
                        </span>
                        <input type="email" class="appearance-none bg-transparent text-midnight font-sans font-light outline-none mb-1 placeholder-zircon w-full" placeholder="{{ __('E-Mail Address') }}" name="email" id="email" required="required" autofocus="true" value="{{old("email")}}">
                    </label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong class="text-red font-sans">{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="password" class="cursor-pointer border-b px-4 py-2 text-midnight flex mb-1 {{ $errors->has('password') ? ' border-red' : 'border-midnight' }}">
                        <span class="mr-4">
                            <i class="fas fa fa-lock"></i>
                        </span>
                        <input type="password" class="appearance-none bg-transparent text-midnight font-sans font-light outline-none mb-1 placeholder-zircon w-full" placeholder="{{ __('Password') }}" name="password" id="password" required="required">
                    </label>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong class="text-red font-sans">{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="flex mb-2">
                    <button class="w-full rounded-full text-zircon py-4 bg-midnight">Se Connecter</button>
                </div>
                <div class="text-midnight text-center mb-8">
                    <a href="{{ route('password.request') }}" class="link-reset font-light">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
                <div class="">
                    <p class="text-center text-midnight font-thin">Vous n'avez pas de compte?  <a href="{{ route('register') }}" class="link-reset font-bold font-sans hover:text-underline">Inscrivez-vous</a></p>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="hidden md:flex h-full w-3/5 justify-center items-center" style="background-image: radial-gradient(rgba(0,0,0,.2), rgba(0,0,0,.4)), url('/img/medecine_bg_one.jpg'); background-position: top center; background-size: cover;"> --}}
    <div class="hidden md:flex h-full w-3/5 justify-center items-center bg-blue" style="background-image:url('/img/signin_bg.png'); background-position: bottom; background-size: 100%; background-repeat: no-repeat;">
        {{-- <div class="py-5">
            <h2 class="uppercase text-white font-sans font-bold text-4xl mb-2 text-center">
                Améliorez la santé.
            </h2>
            <p class="text-center text-white text-xl font-light font-sans uppercase">Facilitez l'accès aux médicaments</p>
        </div> --}}
    </div>
</div>
@endsection
