@extends('layouts.main')

@section('main')

    <style>
        input {
            background-color: yellow;
        }
    </style>

    <livewire:metric-master :project="$project"  />

@endsection
