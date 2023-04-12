@extends('layouts.app')

@section('content')
    <div class="w-full flex flex-col min-h-screen">
        <style>
            #side {
                background: center url({{ Vite::asset('resources/images/login-bg.jpg') }});
            }
        </style>
        @include('futures.partials.header')
        <div class="flex grow">
            <aside id="side" class="text-white">
                <ul class="sticky flex flex-col gap-4 p-4 h-full bg-black/80">
                    <li>Dashboard</li>
                    <li>Product Evaluation</li>
                    <li>Reports</li>
                </ul>
            </aside>
            <main class="flex flex-col max-w-7xl w-full">
                @yield('main')
            </main>
        </div>
    </div>
@endsection
