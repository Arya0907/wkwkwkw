<?php

namespace App\Http\Controllers;

use App\Models\staff_provinces;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Response;

class StaffProvincesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(staff_provinces $staff_provinces)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(staff_provinces $staff_provinces)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, staff_provinces $staff_provinces)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(staff_provinces $staff_provinces)
    {
        //
    }

    public function chart (Request $request)
    {
        $report = Report::all();
        $response = Response::all();

        $report_count = count($report);
        $response_count = count($response);

        return view('chart', compact('report_count', 'response_count'));
    }
}
