<?php

namespace App\Http\Controllers\AdminController;

use App\CarType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_types = CarType::orderBy('id' , 'desc')->paginate(10);
        return  view('admin.car_types.index' , compact('car_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('admin.car_types.create');
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
            'name' => 'required'
        ]);
        // create new car type
        CarType::create([
            'name' =>$request->name,
        ]);
        return  redirect()->route('CarType')->with('information' , 'تم تسجيل  البيانات بنجاح');
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
        $car_type = CarType::findOrFail($id);
        return  view('admin.car_types.edit' , compact('car_type'));
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
            'name' => 'required'
        ]);
        $car_type = CarType::findOrFail($id);
        $car_type->update([
            'name' =>$request->name,
        ]);
        return  redirect()->route('CarType')->with('information' , 'تم تعديل البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_type = CarType::findOrFail($id);
        $car_type->delete();
        return  redirect()->route('CarType')->with('information' , 'تم حذف البيانات بنجاح');
    }
}
