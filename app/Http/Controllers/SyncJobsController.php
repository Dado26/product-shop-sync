<?php

namespace App\Http\Controllers;

class SyncJobsController extends Controller
{
    /**
     * Display a listing of jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jobs.index');
    }
}
