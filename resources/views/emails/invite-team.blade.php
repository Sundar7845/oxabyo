@extends('layouts.email')
@section('content')
    <p style="font-style: normal; font-weight: bold; line-height: 150%;"><span style="color:#333333"><span
                style="font-family:roboto,helvetica neue,helvetica,arial,sans-serif"><span style="font-size:24px">Hey
                    there!<br>
                    {{ $data['user_name'] }} invited you to join the Team {{ $data['team_name'] }} <br>
                    <br>
    </p>
@endsection
@section('link-content')
    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Roboto, " Helvetica Neue", Helvetica,
        Arial, sans-serif; font-size: 18px; padding: 18px;">
        <a class="mcnButton " title="Log-In" href="{{ url(route('team-activation', ['token' => $data['link']])) }}"
            target="_blank"
            style="text-decoration: none;color: #ffffff;padding-top: 11px;background-color: #dc0024;border-collapse: separate!important;border-radius: 45px;border: 3px solid #dc0024;padding: 5px 50px!important;font-size: 18px;line-height: 1.3333333;display: inline-block;font-weight: 500;">Join
            Team</a>
        <a class="mcnButton " title="Log-In"
            href="{{ url(route('team-activation-decline', ['token' => $data['link']])) }}" target="_blank"
            style="text-decoration: none;color: #ffffff;padding-top: 11px;background-color: #dc0024;border-collapse: separate!important;border-radius: 45px;border: 3px solid #dc0024;padding: 5px 50px!important;font-size: 18px;line-height: 1.3333333;display: inline-block;font-weight: 500;">Decline</a>
    </td>
@endsection
