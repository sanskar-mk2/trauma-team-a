@extends('layouts.app')

@section('content')
    <style>
        #bg-img {
            background-image: url({{ Vite::asset('resources/images/login-bg.jpg') }});
        }
    </style>
    <main class="min-h-screen flex">
        <section id="bg-img" class="basis-1/2">
        </section>
        <section class="basis-1/2">
            <div class="bg-gray-100 h-screen flex flex-col justify-center items-center p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">
                    Login
                </h1>
                <p class="text-gray-600 mb-8">
                    Enter your email and password to login.
                </p>
                <form class="bg-blue-500 w-full shadow-md rounded-xl px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Email">
                    </div>
                    <div>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Password">
                    </div>
                    <div class="my-3">
                        <input type="checkbox" name="remember" id="remember">
                        <label class="text-white" for="remember">Remember me</label>
                    </div>
                    <div class="flex items-center justify-center">
                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none w-full focus:shadow-outline" type="button">
                            LOGIN
                        </button>
                    </div>
                </form>
                <p class="text-center text-gray-500 text-xs">
                    &copy;2020 Seyom. All rights reserved.
                </p>
            </div>
        </section>
    </main>
@endsection
