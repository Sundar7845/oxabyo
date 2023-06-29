@extends('layouts.email')
@section('content')
    <p style="font-style: normal; font-weight: bold; line-height: 150%;"><span style="color:#333333"><span
                style="font-family:roboto,helvetica neue,helvetica,arial,sans-serif"><span style="font-size:24px">Hey
                    there!<br>
                    {{ $data }}<br>
                    <br>
    </p>
@endsection

