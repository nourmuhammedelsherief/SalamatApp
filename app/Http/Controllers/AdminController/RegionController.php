<?php

namespace App\Http\Controllers\AdminController;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Redirect;



class RegionController extends Controller
{
    //
    public function index()
    {
        //

            $cities = City::where('parent_id','!=',null)->orderBy('id','desc')->get();
//        dd($cities);
            return view('admin.regions.index',compact('cities'));

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

            $countries = City::orderBy('id','desc')->where('parent_id',null)->get();
            return view('admin.regions.create',compact('countries'));

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
            "country"  => "required",

        ]);

        $request['parent_id']= request('country');

        City::create($request->all());

        return redirect('admin/region');

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

            $city= City::findOrfail($id);
            $countries = City::orderBy('id','desc')->where('parent_id',null)->get();
            return view('admin.regions.edit',compact('countries','city'));
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
            "country"  => "required",

        ]);

        $request['parent_id']= request('country');

        City::where('id',$id)->first()->update($request->all());
        return redirect('admin/region');
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

            $cities = City::findOrfail($id);
            $users = User::where('region_id',$id)->get();
            $regions = City::where('parent_id',$id)->get();

            if ( count($users) == 0 && count($regions) == 0){
            $cities->delete();
            return back();

            }else{
                return Redirect::back()->with('msg', 'لا تسطيع مسح المدينة لانها مستخدمة');
            }
//


    }
}
