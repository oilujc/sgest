<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Services\SlugService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllContacts()
    {
        // logic to get all contacts goes here
        $students = Contact::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
    }

    public function createContact(Request $request)
    {
        // logic to create a contact record goes here
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;

        $slug = SlugService::createSlug($request->name);

        $contact->avatar = "https://ui-avatars.com/api/?name={$slug}&background=0D8ABC&color=fff";
        $contact->save();

        return response()->json([
            "contact" => $contact->toJson(JSON_PRETTY_PRINT)
        ], 201);
    }

    public function getContact($id)
    {
        // logic to get a contact record goes here
        if (Contact::where('id', $id)->exists()) {
            $contact = Contact::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($contact, 200);
        } else {
            return response()->json([
                "message" => "Contact not found"
            ], 404);
        }
    }

    public function updateContact(Request $request, $id)
    {
        // logic to update a contact record goes here
        if (Contact::where('id', $id)->exists()) {
            $contact = Contact::find($id);
            $contact->name = is_null($request->name) ? $contact->name : $request->name;
            $contact->phone = is_null($request->phone) ? $contact->phone : $request->phone;
            $contact->email = is_null($request->email) ? $contact->email : $request->email;

            $slug = SlugService::createSlug($contact->name);

            $contact->avatar = "https://ui-avatars.com/api/?name={$slug}&background=0D8ABC&color=fff";

            $contact->save();

            return response()->json([
                "contact" => $contact
            ], 200);

        } else {
            return response()->json([
                "message" => "Contact not found"
            ], 404);
        }
    }

    public function deleteContact($id)
    {
        // logic to delete a contact record goes here
        if(Contact::where('id', $id)->exists()) {
            $contact = Contact::find($id);
            $contact->delete();
    
            return response()->json([
              "message" => "records deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Contact not found"
            ], 404);
          }
    }
}
