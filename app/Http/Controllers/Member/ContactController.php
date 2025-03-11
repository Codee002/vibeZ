<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view("pages.components.contact");
    }

    public function handleContact(Request $request)
    {
        dd($request);
    }
}
