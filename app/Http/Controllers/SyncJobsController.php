<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
       // $queuedJobs = DB::select("SELECT COUNT(*) AS queued_jobs FROM jobs");
       
        $queuedJobs = DB::table('jobs')->count();

        $jobsFails = DB::table('failed_jobs')->count();

        return view('jobs.index', compact('queuedJobs', 'jobsFails'));
    }
}
