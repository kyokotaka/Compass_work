<?php

namespace App\Http\Controllers\Authenticated\Shifts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shifts\Shift;
use App\Models\Users\User;
use Auth;

class ShiftsController extends Controller
{
    public function scheduleShow(){
        $shifts = Shift::with('user')->get();
        return view('authenticated.shifts.schedule', compact('shifts'));
    }

    public function shiftInput(){
        return view('authenticated.shifts.input');
    }
}

