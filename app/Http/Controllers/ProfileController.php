<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile() {
        try {
            $user = Auth::user();
            $data = User::find($user->id);
            
            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
