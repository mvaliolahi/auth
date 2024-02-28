@extends('auth::layouts.app')

@section('title', trans('auth::messages.verify'))

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
                <h1>{{trans('messages::auth.verification_title', ['title' => $mobile])}}</h1>
            </div>

            {{-- Subtitle --}}
            <div class="text-xl my-4">
                <h1>{{trans('messages::auth.verification_subtitle')}}</h1>
            </div>

            {{-- Vefiry Form --}}
            <div>
                <form action="{{route('auth.verify')}}" method="POST">
                    @csrf
                    {{-- Token --}}
                    <div>
                        <input name="token" class="border  w-full rounded py-3 px-2 hover:none" type="text"
                            placeholder="{{trans('messages::auth.token')}}" />
                        @if($errors->has('token'))
                        <span class="flex justify-center items-center w-full text-red-500 mt-2">
                            {{ $errors->first('token') }}
                        </span>
                        @endif
                    </div>

                    {{-- token Hidden --}}
                    <div>
                        <input type="hidden" name="mobile" value="{{$mobile}}">
                    </div>

                    {{-- Submit --}}
                    <div class="mt-5">
                        <button type="submit"
                            class="bg-blue-400 text-white w-full py-3 rounded-full    hover:bg-blue-300">
                            {{trans('messages::auth.continue')}}
                        </button>
                    </div>
                </form>

                {{-- Send Token Again Form --}}
                <div class="mt-5">
                    <form action="{{route('auth.send.token')}}" method="POST">
                        @csrf

                        <div>
                            <input name="mobile" type="hidden" value="{{$mobile}}">
                        </div>

                        <div class="text-gray-700">
                            <h1 class="text-lg">
                                <span id='timer' class="text-blue-400">00:00</span>
                                @lang('auth::messages.did not received the code')
                            </h1>
                            <button id="resendButton" type="submit" class="invisible text-blue-400 cursor-pointer">
                                @lang('auth::messages.resend')
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

 function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    var interval =  setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(interval);
            document.querySelector('#resendButton').style.visibility = 'visible';
        }
    }, 1000);
};

startTimer({{config('mvaliolahi_auth.token_expire')}} * 1, document.querySelector('span#timer'));

</script>
@endpush
