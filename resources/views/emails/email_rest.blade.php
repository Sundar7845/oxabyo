@extends('layouts.email')

@section('content')
<p style="font-style: normal; font-weight: bold; line-height: 150%;"><span style="color:#333333"><span style="font-family:roboto,helvetica neue,helvetica,arial,sans-serif"><span style="font-size:24px">Hey there!<br>
    You are receiving this email because we received a password reset request for your account.<br>
        <br>       
        If you did not request a password reset, no further action is required.
    </p>
@endsection

@section('link-content')
<td align="center" valign="middle" class="mcnButtonContent" style="font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 18px; padding: 18px;">				
    <a class="mcnButton " title="Reset Password" href="{{ url('/password/reset') }}/{{ $token }}" 
        target="_blank" style="text-decoration: none;color: #ffffff;padding-top: 11px;background-color: #dc0024;border-collapse: separate!important;border-radius: 45px;border: 3px solid #dc0024;padding: 5px 20px !important;font-size: 18px;line-height: 1.3333333;display: inline-block;font-weight: 500;">Reset Password</a>				
</td>	
@endsection
