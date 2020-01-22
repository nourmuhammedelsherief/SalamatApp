<?php

namespace App\Http\Controllers\AdminController;


use App\Nationality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Auth;


class NationalityController extends Controller
{
    //
    public function index()
    {


            $places = Nationality::orderBy('id','desc')->paginate(10);
            return view('admin.nationalities.index',compact('places'));

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


            return view('admin.nationalities.create',compact('countries'));

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
            "name"  => "required|string|max:225",


        ]);
        $places = new Nationality();
        $places->name= $request->name;

        $places->save();
        return redirect('admin/nationality');
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


            $place= Nationality::find($id);

            return view('admin.nationalities.edit',compact('place'));

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
            "name"  => "required|string|max:225",



        ]);
        $places = Nationality::find($id);
        $places->name= $request->name;

        $places->save();
        return redirect('admin/nationality');
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


            $places = Nationality::findOrfail($id);

            $ages =DB::table('users')->where('nationality_id','=',$places->id)->get();

            if ( count($ages) == 0){
//

                $places->delete();
                return back();
            }else{

                return Redirect::back()->with('msg', 'لا تسطيع مسح الجنسية لانه مستخدم');

            }

//


    }
}
