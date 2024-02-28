@extends('auth::layouts.app')

@section('title', trans('auth::messages.login'))

@section('content')

<div class="flex h-screen ">

    {{-- Left --}}
    <div class="hidden md:flex flex-col justify-center items-center w-1/3 bg-blue-400 shadow-xl">

        {{-- Slogan --}}
        <div class="my-10 text-white md:px-10">
            <h1 class="text-xl">
                {{ config('mvaliolahi_auth.slogan') }}
            </h1>
        </div>

        {{-- Image --}}
        <div class="w-1/3">
            <img src="{{asset('vendor/mvaliolahi/auth/images/login.png')}}" alt="">
        </div>

    </div>

    {{-- Right --}}
    <div class="flex flex-col justify-center items-center w-full h-screen text-gray-700 p-10">

        <div class="text-right">
            {{-- Title --}}
            <div class="text-3xl ">
                <h1>{{trans('auth::messages.title')}}</h1>
            </div>

            {{-- Subtitle --}}
            <div class="text-xl my-4">
                <h1>{{trans('auth::messages.subtitle')}}</h1>
            </div>

            {{-- Form --}}
            <div>
                <form action="{{route('auth.send.token')}}" method="POST">
                    @csrf
                    {{-- Mobile --}}
                    <div>
                        <input name="mobile" class="border  w-full rounded py-3 px-2 hover:none" type="text"
                            placeholder="{{trans('auth::messages.mobile')}}" />
                        @if($errors->has('mobile'))
                        <span class="flex justify-center items-center w-full text-red-500 mt-2">
                            {{ $errors->first('mobile') }}
                        </span>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div class="mt-5">
                        <button type="submit"
                            class="bg-blue-400 text-white w-full py-3 rounded-full    hover:bg-blue-300">
                            {{trans('auth::messages.continue')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@endsection
