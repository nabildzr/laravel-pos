@extends('layout.layout')
@php
    $title = 'Users List';
    $subTitle = 'Users List';
    $script = '<script src="' . asset('assets/js/data-table.js') . '"></script>
    <script>
        $(".remove-button").on("click", function() {
            $(this).closest(".alert").addClass("hidden")
        });
    </script>
    
    
    
    ';
@endphp

@section('content')
    @livewire('users.users-list-component')
@endsection
