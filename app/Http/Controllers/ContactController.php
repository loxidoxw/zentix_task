<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddContactRequest;
use App\Models\Contact;
use App\Models\Phone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @param $ajax
     * @return string
     */
    public function index($ajax = false): string
    {
        $contacts = Contact::with('phoneNumbers')->orderBy('id', 'DESC')->paginate(10);

        return view('contact.index', compact('contacts', 'ajax'))->render();
    }

    /**
     * @param AddContactRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(AddContactRequest $request)
    {
        $validated = $request->validated();

        $contact = Contact::create([
            'firstName' => $validated['firstName'],
            'lastName' => $validated['lastName'],
        ]);

        foreach ($validated['phoneNumbers'] as $number) {
            Phone::create([
                'contact_id' => $contact->id,
                'phoneNumber' => $number
            ]);
        }

        if ($request->ajax()) {

            $contacts=Contact::with('phoneNumbers')->orderBy('id', 'DESC')->paginate(10);

            return response()->json([
                'message' => 'Contact created successfully.',
                'result' => 'success',
                'html' => $this->index(true)
            ], 200);
        }

        return redirect()->route('contact.index')->with('success', 'Contact created successfully.');
    }

    /**
     * @param Contact $contact Екземпляр моделі Contact, який потрібно відредагувати.
     * @return \Illuminate\View\View Представлення з формою редагування контакту.
     */
   public function edit(Contact $contact)
   {
       $contact->load('phoneNumbers');
       return view('contact.edit', compact('contact'));
   }

    /**
     * @param AddContactRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(AddContactRequest $request, Contact $contact): RedirectResponse
    {
       $validated = $request->validated();

       $contact->update([
           'firstName' => $validated['firstName'],
           'lastName' => $validated['lastName'],
       ]);


       $contact->phoneNumbers()->delete();

       foreach ($validated['phoneNumbers'] as $number) {
           $contact->phoneNumbers()->create([
               'phoneNumber' => $number
           ]);
       }

       return redirect()->route('contact.index')->with('success', 'Contact updated successfully.');
   }

    /**
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->phoneNumbers()->delete();
        $contact->delete();

        return redirect()->route('contact.index')->with('success');
    }
}
