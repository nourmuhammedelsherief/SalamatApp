<?php

namespace App\Http\Controllers\AdminController;

use App\Age;
use App\ModelCity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Auth;
use PHPUnit\Framework\Constraint\Count;

class ModelCityController extends Controller
{
    //
    public function index()
    {


            $places = ModelCity::orderBy('id','desc')->paginate(10);
            return view('admin.city_models.index',compact('places'));

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


            return view('admin.city_models.create',compact('countries'));

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
            "year"  => "required|numeric",


        ]);
        $places = new ModelCity();
        $places->year= $request->year;

        $places->save();
        return redirect('admin/modelCity');
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


            $place= ModelCity::find($id);

            return view('admin.city_models.edit',compact('place'));

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
            "year"  => "required|numeric",


        ]);
        $places = ModelCity::find($id);
        $places->year= $request->year;

        $places->save();
        return redirect('admin/modelCity');
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


            $places = ModelCity::findOrfail($id);

            $ages =DB::table('users')->where('city_mode_id','=',$places->id)->get();

            if ( count($ages) == 0){
//

                $places->delete();
                return back();
            }else{

                return Redirect::back()->with('msg', 'لا تسطيع مسح موديل السنة لانه مستخدم');

            }

//


    }
}
