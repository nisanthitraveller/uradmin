<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductTile;
use Carbon\Carbon;

class TilesController extends Controller
{
    public function index()
    {
        //abort_unless(\Gate::allows('team_access'), 403);

        $tiles = ProductTile::with('category')->orderBy('id', 'desc')->get();

        return view('admin.tiles.index', compact('tiles'));
    }

    public function create()
    {
        //abort_unless(\Gate::allows('team_create'), 403);
        $categories = \App\Category::all(['id', 'category_name']);
        return view('admin.tiles.create', compact('categories'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        //abort_unless(\Gate::allows('team_create'), 403);
        $team = ProductTile::create($request->all());

        return redirect()->route('admin.tiles.index');
    }

    public function edit(ProductTile $tile)
    {
        //abort_unless(\Gate::allows('team_edit'), 403);
        $categories = \App\Category::all(['id', 'category_name']);
        return view('admin.tiles.edit', compact('tile', 'categories'));
    }

    public function update(\Illuminate\Http\Request $request, ProductTile $tile)
    {
        $tile->update($request->all());
        

        return redirect()->route('admin.tiles.index');
    }

    public function show(Team $team)
    {
        //abort_unless(\Gate::allows('team_show'), 403);

        return view('admin.teams.show', compact('team'));
    }

    public function destroy(ProductTile $tile)
    {
        //abort_unless(\Gate::allows('team_delete'), 403);
        $tile->delete();

        return back();
    }

    public function massDestroy()
    {
        ProductTile::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
    
}
