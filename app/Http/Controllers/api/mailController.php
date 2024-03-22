<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\acceptedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class mailController extends Controller
{


    public function send()
    {
         Mail::to(Auth::user()->email)->send(new acceptedMail);
         return response()->json(['message' => 'email sended successfully']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
