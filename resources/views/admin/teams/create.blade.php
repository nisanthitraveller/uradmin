@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.team.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.teams.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.team.fields.team_name') }}*</label>
                <input type="text" id="team_name" name="team_name" class="form-control" value="{{ old('team_name', isset($team) ? $team->team_name : '') }}">
                @if($errors->has('team_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('team_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.team.fields.name_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection