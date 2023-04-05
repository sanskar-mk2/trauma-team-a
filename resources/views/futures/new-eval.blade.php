@extends('layouts.app')

@section('content')
    <div class="w-full flex flex-col min-h-screen">
        @include('futures.partials.header')
        <div class="flex grow">
            <aside class="bg-black text-white">
                <ul class="sticky">
                    <li>First</li>
                    <li>Second</li>
                </ul>
            </aside>
            <main class="flex flex-col max-w-7xl w-full">
                MAIN
            </main>
        </div>
    </div>
@endsection
