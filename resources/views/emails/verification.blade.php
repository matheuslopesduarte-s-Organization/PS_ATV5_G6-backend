
@extends('emails.layouts.default')

@section('content')
    <p>Hi {{ $details['name'] }},</p>
    <p>Thanks for signing up with us. Please click the link below to verify your email address:</p>
    <p>your verification code is: {{ $details['token']}}</p>
    <p>If you did not sign up with us, please ignore this email.</p>
@endsection


