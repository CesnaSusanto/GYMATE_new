<?php
// app/Http/Controllers/PersonalTrainerController.php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use App\Models\User; // Digunakan untuk relasi user_id
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Validation\Rule; // Untuk validasi enum role

class PersonalTrainerController extends Controller
{
    
}
