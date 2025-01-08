<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>
    <style>
        .text-center {
            text-align: center;
            border: 1px solid #333
        }

        div {
            left: 20%;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            @foreach ($dataProduk as $index => $product)
            <td class="text-center">
                <p>{{ $product->product_name }} - {{ format_uang($product->purchase_price) }}</p>
                {!! $barcodes[$index] !!}
                {{ $product->product_code }}
                {{-- <img src="data:image/png;base64, {!! DNS1D::getBarcodePNG($product->product_code, 'C39+') !!} "
                    alt="barcode" width="180" height="60" /> --}}
            </td>
            @if ($loop->iteration++ % 3 ==0)
        </tr>
        <tr>
            @endif
            @endforeach
            {{-- @foreach ($dataProduk as $index => $product)
            <td class='text-center'>
                <p>{{ $product->product_name }} - {{ format_uang($product->purchase_price) }}</p>

                {!! DNS1D::getBarcodeHTML($product->product_code, 'CODABAR') !!}

                <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($product->product_code, 'C39') !!}"
                    alt="{{ $product->product_code }}" width="180" height="60">
                <br>
                {{ $product->product_code }}
                {!! $barcodes[$index] !!}
            </td>
            @endforeach --}}
        </tr>
    </table>
</body>

</html>