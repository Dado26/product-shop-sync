<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SyncRules;

use App\Http\Requests\SitesRequest;
use App\Models\Site;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::latest()->paginate(5);

        return view('sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SitesRequest $request)
    {
        $param = $request->all();

        $site = auth()->user()->Sites()->create($param['sites']); 

        $param['sync_Rules']['site_id'] = $site->id;

        SyncRules::create($param['sync_Rules']);

        flash('Message')->success('you have succesfully create new site');

        flash('Message')->error('Ups something went wrong');

        return redirect()->route('sites.index');

        

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
    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Site $site)
    {
        $param = $request->all();

        $site->update($param['sites']); 

        $site->SyncRules->update($param['sync_Rules']);

        flash('Message')->success('you have succesfully update site');

        flash('Message')->error('Ups something went wrong');

        return redirect()->route('sites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $site->delete();
        flash('you have succesfully deleted site')->success();
        return redirect()->back();
    }
}
