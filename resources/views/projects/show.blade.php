@extends('layouts.app')

@section('content')

    <style>
        input {
            background-color: yellow;
        }
    </style>

    <livewire:metric-master :project="$project"  />

@endsection
