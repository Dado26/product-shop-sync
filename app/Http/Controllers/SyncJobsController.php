<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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
