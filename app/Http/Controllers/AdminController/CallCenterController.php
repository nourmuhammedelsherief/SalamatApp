<?php

namespace App\Http\Controllers\AdminController;

use App\CallCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calls = CallCenter::orderBy('id' , 'desc')->paginate(1);
        return view('admin.calls.index' , compact('calls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.calls.create');
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
        CallCenter::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'photo'  => $request->file('photo') == null ? null : UploadImage($request->file('photo'), 'image', '/uploads/call_center'),
        ]);
        return redirect()->route('call_center')->with('information' , 'تم انشاء الاتصال بنجاح');
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
        $call = CallCenter::findOrFail($id);
        return view('admin.calls.edit' , compact('call'));
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
        $call = CallCenter::findOrFail($id);
        $call->update([
            'name'=>$request->name == null ? $call->name : $request->name,
            'phone'=>$request->phone == null ? $call->phone : $request->phone,
            'photo'  => $request->file('photo') == null ? $call->photo : UploadImage($request->file('photo'), 'image', '/uploads/call_center'),
        ]);
        return redirect()->route('call_center')->with('information' , 'تم تعديل الاتصال بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $call = CallCenter::findOrFail($id);
        $call->delete();
        return redirect()->route('call_center')->with('information' , 'تم حذف الاتصال بنجاح');

    }
}
