<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cetak Card Member</title>

  <style>
    .box {
      position: relative;
      border: 1px solid black;
    }

    .card {
      width: 85.60em;
    }

    .logo {
      position: absolute;
      top: 3pt;
      right: 0;
      font-size: 16pt;
      font-family: Arial, Helvetica, sans-serif;
      font-weight: bold;
      columns: #fff;
    }

    .logo p {
      text-align: right;
      margin-right: 14pt;
    }

    .logo img {
      position: absolute;
      margin-top: -5pt;
      widows: 40px;
      height: 40px;
      right: 16pt;
    }
  </style>
</head>

<body>
  <section style="border: 1px solid #fff">
    <table width="100%">
      @foreach ($dataMember as $key => $data)
        <tr>
          @foreach ($data as $index => $item)
            <td class="text-center" width="50%">
              <div class="box">
                <img src="{{ asset('img/member.jpg') }}" class="img-circle" alt="User Image">
                <div class="logo">
                  <p>{{ config('app.name') }}</p>
                  <img src="{{ asset('AdminLTE-2/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                </div>
                <div class="nama">{{ config('app.name') }}</div>
                <div class="telepon">{{ $item->phone }}</div>
                {{-- <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($item->member_code, 'QRCODE') !!}" alt="QRCODE" width="45" height="45"> --}}

                <div class="barcode">
                  {!! DNS2D::getBarcodeHTML('$item->member_code', 'QRCODE', 2, 2) !!}
                </div>


              </div>
            </td>
          @endforeach
        </tr>
      @endforeach
    </table>
  </section>
</body>

</html>
