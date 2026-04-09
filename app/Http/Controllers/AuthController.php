<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return "Redirect ke Google SSO (belum diaktifkan)";
    }

    public function handleGoogleCallback()
    {
        return "Callback dari Google";
    }
}