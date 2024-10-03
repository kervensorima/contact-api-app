<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //

    public function search(Request $request)
    {

        $query = Contact::query();

        // dd($query);

        // $perPage = 2;
        $page = $request->input("page", 1);
        $size = $request->input("size", 15);
        $search = $request->input("search", "");


        if ($search) {
            $query->whereRaw("first_name LIKE ?", ["%$search%"]);
        }


        $total = $query->count();
        $data = $query->offset(($page - 1) * $size)->limit($size)->get();

        return response()->json([
            "message" => "contact retrieved successfully",
            "data" => $data,
            "success" => true,
            "page" => $page,
            "size" => $size,
            "total" => (ceil($total / $size)),
            "search" => $search
        ]);
    }

    public function index()
    {
        $contacts = Contact::all();

        return response()->json([
            "message" => "contact retrieved successfully",
            "data" => $contacts,
            "code" => 200,
        ], 200, []);
    }


    public function store(ContactRequest $request)
    {
        $contact = new Contact();
        $contact->first_name = "$request->first_name";
        $contact->last_name = $request->last_name;
        $contact->email  = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->address = $request->address;

        $contact->save();

        return response()->json([
            "message" => "contact created successfully",
            "data" => $contact,
            "code" => 201,
            "success" => true
        ], 201, []);;
    }



    public function update(UpdateContactRequest $request, int $id)
    {

        $contact = Contact::find($id);

        if (empty($contact)) {
            return response()->json([
                "message" => "contact not found",
                "data" => null,
                "code" => 404,
                "success" => false
            ]);
        }
        $contact->first_name = "$request->first_name";
        $contact->last_name = $request->last_name;
        $contact->email  = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->address = $request->address;

        $contact->update();

        return response()->json([
            "message" => "contact updated successfully",
            "data" => $contact,
            "code" => 201,
            "success"    => true
        ]);
    }


    public function findById(int $id)
    {
        $contact = Contact::find($id);

        if (empty($contact)) {
            return response()->json([
                "message" => "contact not found",
                "data" => null,
                "code" => 404,
                "success" => false
            ]);
        }
        return response()->json([
            "data" => $contact,
            "success" => true,
            "message" => "contact retrieved successfully",
            "code" => 200,
        ]);
    }


    public function delete(Contact $contact)
    {
        // delete the contact
        $contact->delete();

        return response()->json([
            "message" => "contact deleted successfully",
            "data" => $contact,
            "code" => 200 ,
            'success' => true
        ]);
    }
}
