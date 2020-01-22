<?php

namespace App\Http\Controllers\AdminController;

use App\City;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;


class CountryController extends Controller
{
    //
    public function index()
    {
        //


            $countries = City::where('parent_id',null)->orderBY('id','desc')->get();
            return view('admin.countries.index',compact('countries'));

//


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //




        return view('admin.countries.create');

//


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            "name"  => "required|string|max:255",


        ]);

        $request['parent_id']=null;
        City::create($request->all());

        return redirect('admin/country');
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
        //


            $country = City::findOrfail($id);
            return view('admin.countries.edit',compact('country'));

//


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
        //
        $this->validate($request, [
            "name"  => "required|string|max:255",


        ]);
        $countries = City::findOrfail($id);

        $countries->name = $request->name;

        $countries->save();
        return redirect('admin/country');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //


            $countries = City::find($id);
            $cities = City::where('parent_id',$id)->get();
            $users = User::where('city_id',$id)->get();
            if (count($cities) !== 0 && count($users) !== 0){
                return Redirect::back()->with('msg', 'لا تسطيع مسح المدينة لانها مستخدمة');
            }else{
                $countries->delete();
                return back();
            }
//



    }
}
