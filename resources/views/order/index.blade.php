@extends('layout.layout-no-breadcrumb')
@php
    $script = '
    <script>
        $(".remove-button").on("click", function() {
            $(this).closest(".alert").addClass("hidden")
        });
    </script>
  
    ';
@endphp


@section('content')
    @livewire('order-component')
@endsection
