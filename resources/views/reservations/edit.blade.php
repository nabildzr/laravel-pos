@extends('layout.layout')
@php
    $title = "Edit Reservation #$reservation->id" ;
    $subTitle = 'Point of Sales';
    $script = ' 
<script>
    $(".remove-button").on("click", function() {
        $(this).closest(".alert").addClass("hidden")
    });
</script>
    ';
@endphp

@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            @livewire('reservation.reservation-edit', ['reservationId' => $reservation->id])
        </div>
    </div>
@endsection