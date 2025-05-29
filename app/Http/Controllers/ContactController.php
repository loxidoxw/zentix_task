<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddContactRequest;
use App\Models\Contact;
use App\Models\Phone;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        $contacts=Contact::with('phoneNumbers')->paginate(10);

        return view('contact.create', compact('contacts'));
    }

   public function store(AddContactRequest $request)
   {
       $request->validated();

       $contact = Contact::create([
           'firstName'=>$request->firstName,
           'lastName'=>$request->lastName
       ]);

       foreach ($request->phoneNumbers as $phoneNumber)
       {
           Phone::create([
               'contact_id' => $contact->id,
               'phoneNumber' => $phoneNumber
           ]);
       }
   }
}
