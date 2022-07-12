<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistrationController extends Controller
{
    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->back();
    }
}
