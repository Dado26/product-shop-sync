<?php

namespace App\Http\Controllers;

use App\Models\SyncRules;
use App\Http\Requests\SitesRequest;
use App\Models\Site;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sites = Site::withCount('productsActive', 'productsUnavailable', 'productsDeleted', 'productsTrashed')->latest()->paginate(10);

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
     * @param \App\Http\Requests\SitesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SitesRequest $request)
    {
        $param = $request->all();

        $site = auth()->user()->sites()->create($param['sites']);

        $param['sync_Rules']['site_id'] = $site->id;

        SyncRules::create($param['sync_Rules']);

        flash('You have successfully created new site')->success();

        return redirect()->route('sites.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Site $site
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SitesRequest $request
     * @param \App\Models\Site                $site
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SitesRequest $request, Site $site)
    {
        $param = $request->all();

        $site->update($param['sites']);

        $site->syncRules->update($param['sync_Rules']);

        flash('You have successfully updated site')->success();

        return redirect()->route('sites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Site $site
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Site $site)
    {
        $site->delete();

        flash('You have successfully deleted site')->success();

        return redirect()->back();
    }
}
