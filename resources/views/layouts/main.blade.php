@extends('layouts.app')

@section('content')
    <main class="flex flex-col min-h-screen">
        <style>
            #side {
                background: center url({{ Vite::asset('resources/images/login-bg.jpg') }});
            }
        </style>
        <x-header />
        <section class="flex grow">
            <aside id="side" class="text-white">
                <div class="bg-black/80 h-full">
                    <ul class="sticky p-4 top-20 flex flex-col gap-4">
                        <li>Dashboard</li>
                        <li>Product Evaluation</li>
                        <li>Reports</li>
                    </ul>
                </div>
            </aside>
            <div class="flex flex-col">
                @yield('main')
            </div>
        </section>
    </main>
@endsection
