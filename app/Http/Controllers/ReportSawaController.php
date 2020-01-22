<?php

namespace App\Http\Controllers;

use App\ReportSawa;
use Illuminate\Http\Request;

class ReportSawaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = ReportSawa::orderBy('id','desc')->paginate(10);
//        $reports = ReportSawa::all();
        return view('admin.reports.index' , compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReportSawa  $reportSawa
     * @return \Illuminate\Http\Response
     */
    public function show(ReportSawa $reportSawa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReportSawa  $reportSawa
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportSawa $reportSawa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReportSawa  $reportSawa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportSawa $reportSawa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReportSawa  $reportSawa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = ReportSawa::find($id);
        $report->delete();
        return redirect('/admin/reports');
    }
}
