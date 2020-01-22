<?php

namespace App\Http\Controllers;

use App\Reson;
use Illuminate\Http\Request;

class ResonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = Reson::orderBy('id','desc')->paginate(10);
        return view('admin.reasons.index',compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "reason"  => "required",
        ]);
        $reason = new Reson();
        $reason->reason = $request->reason;
        $reason->save();
        return redirect('/admin/reasons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reson  $reson
     * @return \Illuminate\Http\Response
     */
    public function show(Reson $reson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reson  $reson
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reason = Reson::find($id);
        return view('admin.reasons.edit' , compact('reason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reson  $reson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reason = Reson::find($id);
        $reason->reason = $request->reason;
        $reason->save();
        return redirect('/admin/reasons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reson  $reson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reason = Reson::find($id);
        $reason->delete();
        return redirect('/admin/reasons');
    }
}
