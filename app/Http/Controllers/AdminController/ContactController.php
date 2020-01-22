<?php

namespace App\Http\Controllers\AdminController;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('id' , 'desc')->paginate(10);
        return view('admin.app_contacts.index' , compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.app_contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request , [
             'name' =>'required',
             'phone' =>'required',
             'photo'  => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
         ]);
         Contact::create([
             'name'=>$request->name,
             'phone'=>$request->phone,
             'photo'  => $request->file('photo') == null ? null : UploadImage($request->file('photo'), 'image', '/uploads/contacts_photos'),
         ]);
         return redirect()->route('Contacts')->with('information' , 'تم انشاء الاتصال بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.app_contacts.edit' , compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request , [
            'name' =>'required',
            'phone' =>'required',
            'photo'  => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
        ]);
        $contact = Contact::findOrFail($id);
        $contact->update([
            'name'=>$request->name == null ? $contact->name : $request->name,
            'phone'=>$request->phone == null ? $contact->phone : $request->phone,
            'photo'  => $request->file('photo') == null ? $contact->photo : UploadImage($request->file('photo'), 'image', '/uploads/contacts_photos'),
        ]);
        return redirect()->route('Contacts')->with('information' , 'تم انشاء الاتصال بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('Contacts')->with('information' , 'تم انشاء الاتصال بنجاح');
    }
}
