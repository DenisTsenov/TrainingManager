<?php

namespace App\Http\Controllers\Auth\Sports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SportController extends Controller
{
    public function create()
    {
        return view('auth.sports.create');
    }

    public function store(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {

    }
}
