@extends('layout.layout-no-breadcrumb')

@section('content')
    @livewire('transaction-payment', [
      'isInvoice' => $isInvoice ?? false,
      'transaction' => $transaction,
      'transactionDetail' => $transactionDetail
  ])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Tambah angka
            $('.numpad-btn').on('click', function() {
                let num = $(this).data('num');
                let $input = $('input[name="paid_amount"]');
                $input.val($input.val() + num).trigger('input');
            });

            // Clear
            $('.numpad-clear').on('click', function() {
                let $input = $('input[name="paid_amount"]');
                $input.val('').trigger('input');
            });

            // Backspace
            $('.numpad-back').on('click', function() {
                let $input = $('input[name="paid_amount"]');
                $input.val($input.val().slice(0, -1)).trigger('input');
            });
        });
    </script>

    
@endsection
