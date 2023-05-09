@extends('layouts.app')

@section('content')
    <x-header />
    <div class="w-full flex justify-center p-4">
        <main class="flex flex-col max-w-7xl w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                DASHBOARD
            </h2>
            <div class="text-xl bg-gray-300 p-2">
                Product Evaluation
            </div>
            <div class="flex gap-4 my-4">
                <div style="background: linear-gradient(90deg, #6061C8 0%, #317AE3 100%);" class="rounded text-white w-full">
                    <a href="{{ route('projects.create') }}"
                        class="flex items-center p-4 justify-around cu">
                        <p class="font-semibold text-lg">New Evaluation</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 1.png') }}" alt="evaluate">
                    </a>
                    <div style="background: #545AB7" class="flex justify-center py-1 text-sm items-center gap-2">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div style="background: linear-gradient(90deg, #BC36AA 0%, #D94BCD 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">Review Business Case</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 2.png') }}" alt="evaluate">
                    </div>
                    <div class="flex justify-center py-1 text-sm items-center gap-2" style="background: #AB319B;">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div style="background: linear-gradient(90deg, #8E2FA1 0%, #B35EDB 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">Compare Scenarios</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 3.png') }}" alt="evaluate">
                    </div>
                    <div class="flex justify-center py-1 text-sm items-center gap-2" style="background: #843097;">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div style="background: linear-gradient(90deg, #2DAC34 0%, #51B825 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">Download Molecule Details</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 4.png') }}" alt="evaluate">
                    </div>
                    <div class="flex justify-center py-1 text-sm items-center gap-2" style="background: #2C9B2D;">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="text-xl bg-gray-300 p-2 mt-4">
                Reports
            </div>
            <div class="flex gap-4 my-4 flex-row-reverse">
                <div style="background: linear-gradient(90deg, #6061C8 0%, #317AE3 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">SKU Details</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 8.png') }}" alt="evaluate">
                    </div>
                    <div style="background: #545AB7" class="flex justify-center py-1 text-sm items-center gap-2">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div style="background: linear-gradient(90deg, #BC36AA 0%, #D94BCD 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">Custom Reports</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 7.png') }}" alt="evaluate">
                    </div>
                    <div class="flex justify-center py-1 text-sm items-center gap-2" style="background: #AB319B;">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div style="background: linear-gradient(90deg, #8E2FA1 0%, #B35EDB 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">Product Snapshot</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 6.png') }}" alt="evaluate">
                    </div>
                    <div class="flex justify-center py-1 text-sm items-center gap-2" style="background: #843097;">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div style="background: linear-gradient(90deg, #2DAC34 0%, #51B825 100%);" class="rounded text-white w-full">
                    <div class="flex items-center p-4 justify-around">
                        <p class="font-semibold text-lg">Launch Calendar</p>
                        <img src="{{ Vite::asset('resources/images/evaluate 5.png') }}" alt="evaluate">
                    </div>
                    <div class="flex justify-center py-1 text-sm items-center gap-2" style="background: #2C9B2D;">
                        More Info
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.00002 0C12.4183 0 16 3.58172 16 8C16 12.4182 12.4183 16 8.00002 16C3.58172 16 0 12.4182 0 8C0 3.58172 3.58172 0 8.00002 0ZM8.00002 1.2C4.24446 1.2 1.2 4.24446 1.2 8C1.2 11.7555 4.24446 14.8 8.00002 14.8C11.7555 14.8 14.8 11.7555 14.8 8C14.8 4.24446 11.7555 1.2 8.00002 1.2ZM7.71762 4.44246L7.7757 4.37518C7.98874 4.16216 8.3221 4.14279 8.55698 4.31708L8.62426 4.37518L11.8249 7.57584C12.0379 7.78888 12.0573 8.12224 11.883 8.35712L11.8248 8.42448L8.62362 11.6245C8.3893 11.8587 8.00938 11.8586 7.77506 11.6242C7.5621 11.4112 7.54282 11.0779 7.71714 10.843L7.77522 10.7758L9.95282 8.5992L4.59943 8.59944C4.29568 8.59944 4.04464 8.37368 4.00491 8.08088L3.99943 7.99944C3.99943 7.69568 4.22516 7.44464 4.51802 7.40488L4.59943 7.39944L9.95122 7.3992L7.7757 5.2237C7.56274 5.01069 7.54338 4.67736 7.71762 4.44246Z" fill="white"/>
                        </svg>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
