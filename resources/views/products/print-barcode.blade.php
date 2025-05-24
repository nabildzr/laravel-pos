<!DOCTYPE html>
<html>

<head>
  <title>Print Barcode</title>
  <style>
    @media print {
      body {
        margin: 0;
        padding: 0;
        width: 58mm;
        /* Remove incorrect height property */
      }

      .barcode-area {
        text-align: center;
        font-size: 12px;
      }

      img {
        max-width: 100%;
        height: auto;
      }

      .sku-label {
        margin-top: 5px;
        font-size: 10px;
      }

      @page {
        size: 58mm 30mm; /* Set fixed height instead of auto */
        margin: 0;
      }
    }
  </style>
</head>

<body>
  <div class="barcode-area">
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($sku, 'C128') }}" alt="barcode" />
    <div class="sku-label">{{ $sku }}</div>
    <div class="sku-label">{{ $name ?? '' }}</div>
  </div>
  <script>
    window.onload = function () {
      window.print();
    }
  </script>
</body>

</html>