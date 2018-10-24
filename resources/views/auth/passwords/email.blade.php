@extends('layouts.auth')

@section('content')
<div class="container-lg bg-white h-screen flex">
    <div class="bg-white pt-4 md:p-8 w-full h-full bg-red-light">
        @if (session('status'))
            <div class="flex w-full items-center justify-center mb-4">
                <div class="bg-teal-lightest border-t-4 border-teal rounded-b text-teal-darkest px-4 py-3 shadow-md" role="alert">
                  <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                      <p class="font-bold">{{"Verify your email address!"}}</p>
                      <p class="text-sm">{{__("We have e-mailed your password reset link!")}}</p>
                    </div>
                  </div>
                </div>
            </div>
        @endif
        <h1 class="mt-6 text-white mb-6">
            <a href="{{ url('/') }}" class="link-reset text-center block">
                <img src="/img/logo_white.svg" width="58" alt="{{config('app.name')}}" class="">
                <p class="uppercase text-center font-light mt-1">
                    Santé<span class="inline-block font-bold text-red-dark">Express</span>
                </p>
            </a>
        </h1>
        <div class="md:py-4 w-full px-8 flex justify-center">
            <div class="flex items-center w-2/5 bg-white py-6 px-4 flex-col shadow-lg">
                <h1 class="mb-6 text-midnight font-sans">{{__("Reset Password")}}</h1>
                <form method="POST" action="{{ route('password.email') }}" class="w-full px-4">
                    @csrf
                    <div class="mb-6">
                        <label for="email" class="cursor-pointer border-b px-4 py-2 text-midnight flex items-center mb-1 {{ $errors->has('email') ? ' border-red' : 'border-midnight' }}">
                            <span class="mr-4 mb-1">
                                <i class="fas fa fa-envelope"></i>
                            </span>
                            <input type="email" class="appearance-none bg-transparent text-midnight font-sans font-light outline-none mb-1 placeholder-midnight w-full" placeholder="{{ __('E-Mail Address') }}" name="email" id="email" required="required" autofocus="true">
                        </label>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong class="text-red font-sans">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="flex mb-8">
                        <button class="w-full rounded-full text-zircon py-4 bg-midnight">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                    <div class="">
                        <p class="text-center text-grey font-thin">{{__("Designed by")}}  <a href="{{ route('login') }}" class="link-reset font-bold font-sans hover:text-underline">{{__("Orus inc.")}}</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
