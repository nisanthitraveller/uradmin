<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Team;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function index()
    {
        //abort_unless(\Gate::allows('team_access'), 403);

        $teams = Team::with('owner')->with('members')->orderBy('id', 'desc')->get();

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        //abort_unless(\Gate::allows('team_create'), 403);

        return view('admin.teams.create');
    }

    public function store(StoreTeamRequest $request)
    {
        //abort_unless(\Gate::allows('team_create'), 403);

        $team = Team::create($request->all());

        return redirect()->route('admin.teams.index');
    }

    public function edit(Team $team)
    {
        //abort_unless(\Gate::allows('team_edit'), 403);

        return view('admin.teams.edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        //abort_unless(\Gate::allows('team_edit'), 403);
        if($team->space_type_id == 1 && in_array($request->space_type_id, [2, 3, 4, 6])) {
            \App\TeamMember::where('team_id', $team->id)
                    ->update(['speaker' => 1]);
        }
        $team->update($request->all());
        

        return redirect()->route('admin.teams.index');
    }

    public function show(Team $team)
    {
        //abort_unless(\Gate::allows('team_show'), 403);

        return view('admin.teams.show', compact('team'));
    }

    public function destroy(Team $team)
    {
        //abort_unless(\Gate::allows('team_delete'), 403);
        \App\TeamMember::where('id', $team->id)->delete();
        $team->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Team::whereIn('id', request('ids'))->delete();
        \App\TeamMember::whereIn('team_id', request('ids'))->delete();

        return response(null, 204);
    }
    
    public function massFeed()
    {
        Team::whereIn('id', request('ids'))->update(['feed' => 1]);

        return response(null, 204);
    }
    
    public function members($teamId)
    {
        //abort_unless(\Gate::allows('team_members'), 403);
        $teamObj = new Team();
        $team = $teamObj->where('id', $teamId)->with('members')->first();
        return view('admin.teams.members', compact('team'));
    }
    
    public function vomeetings()
    {
        //abort_unless(\Gate::allows('team_access'), 403);
        $title = 'Virtual Office List';
        $meetings = \Illuminate\Support\Facades\DB::table('meetings')->where('team_id', '!=', 0)->where('type', 6)->orderBy('created_at', 'desc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        });
        return view('admin.teams.vomeetings', compact('meetings', 'title'));
    }
    public function meetings()
    {
        //abort_unless(\Gate::allows('team_access'), 403);
        $title = 'Meeting List';
        $meetings = \Illuminate\Support\Facades\DB::table('meetings')->where('team_id', '!=', 0)->where('type', 3)->orderBy('created_at', 'desc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        });
        
        return view('admin.teams.vomeetings', compact('meetings', 'title'));
    }
}
