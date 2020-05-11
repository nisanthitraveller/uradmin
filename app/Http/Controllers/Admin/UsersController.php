<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $users = User::orderBy('id', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_unless(\Gate::allows('user_show'), 403);

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_unless(\Gate::allows('user_delete'), 403);

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
    public function onlineusers(\Illuminate\Http\Request $request)
    {
        abort_unless(\Gate::allows('user_access'), 403);
        $query = "SELECT * FROM users WHERE DATE(updated_at) = '" . date('Y-m-d') . "' AND status != 2";
        $users = \Illuminate\Support\Facades\DB::select($query);
        
        if(!$request->ajax()) {
            return view('admin.users.online', compact('users'));
        } else {
            $returnHTML = view('admin.users.online_ajax', compact('users'))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }
    
    public function mail(\Illuminate\Http\Request $request)
    {
        $user = User::where('id', $request['userId'])->first();
        return view('admin.users.mail', compact('user'));
    }
    
    public function sendmail(\Illuminate\Http\Request $data) {
        try {
            $saved = \App\Email::create($data->toArray());
            Mail::send('emails.email-template', ['data' => $data], function ($m) use ($data) {
                $m->from('hello@unremot.com', 'Hello UnRemot');
                $m->replyTo($data['email'], $data['name']);
                $m->to($data['email'])->subject($data['subject']);
            });
            return redirect()->back()->with('success', 'Mail sent successfully.');
        } catch(\Exception $e) {
            \Log::info($e->getMessage());
            return redirect()->back()->with('failure', 'Mail failed.');
        }
    }
}
