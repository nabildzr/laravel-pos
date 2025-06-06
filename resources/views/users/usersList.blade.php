@extends('layout.layout')
@php
    $title = 'Users List';
    $subTitle = 'Users List';
    $script = '<script>
        $(".remove-item-btn").on("click", function() {
            $(this).closest("tr").addClass("hidden")
        });
    </script>';
@endphp

@section('content')
   @livewire('users.users-list-component')
@endsection
