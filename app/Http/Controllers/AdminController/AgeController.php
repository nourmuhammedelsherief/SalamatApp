<?php

namespace App\Http\Controllers\AdminController;

use App\Age;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Auth;
use PHPUnit\Framework\Constraint\Count;

class AgeController extends Controller
{
    //
    public function index()
    {


            $places = Age::orderBy('id','desc')->paginate(10);
            return view('admin.ages.index',compact('places'));

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


            return view('admin.ages.create',compact('countries'));

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
            "number"  => "required|numeric",


        ]);
        $places = new Age();
        $places->number= $request->number;

        $places->save();
        return redirect('admin/age');
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


            $place= Age::find($id);

            return view('admin.ages.edit',compact('place'));

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
            "number"  => "required|numeric",


        ]);
        $places = Age::find($id);
        $places->number= $request->number;

        $places->save();
        return redirect('admin/age');
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


            $places = Age::findOrfail($id);

            $ages =DB::table('users')->where('age_id','=',$places->id)->get();

            if ( count($ages) == 0){
//

                $places->delete();
                return back();
            }else{

                return Redirect::back()->with('msg', 'لا تسطيع مسح العمر لانه مستخدم');

            }

//


    }
}
