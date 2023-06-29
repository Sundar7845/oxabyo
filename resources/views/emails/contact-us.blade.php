@extends('layouts.email')
@section('content')
    <p style="font-style: normal; font-weight: bold; line-height: 150%;"><span style="color:#333333">
            <span style="font-family:roboto,helvetica neue,helvetica,arial,sans-serif">
                <span style="font-size:24px">Hey
                    there!<br>
        <h3>Contatto dal sito web</h3>
        <p>Nome: {{ $data['name'] }}</p>
        <p>Cognome: {{ $data['surname'] }}</p>
        <p>Email: {{ $data['email'] }}</p>
        <p>Messaggio: {{ $data['message'] }}</p>
        <br>
    </p>
@endsection
