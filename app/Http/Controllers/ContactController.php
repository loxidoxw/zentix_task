<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Phone;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        $contacts=Contact::with('phones')->paginate(10);
        return view('contact.create', compact('contacts'));
    }


}
