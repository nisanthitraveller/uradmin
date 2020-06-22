@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.team.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.teams.update", [$team->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('team_name') ? 'has-error' : '' }}">
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
            <div class="form-group">
                <label for="holder">Handle</label>
                <input type="text" name="holder" class="form-control" value="{{ old('holder', isset($team) ? $team->holder : '') }}">
            </div>
            <div class="form-group">
                <label>Public/Private</label>
                <input type="text" name="privacy" class="form-control" value="{{ old('privacy', isset($team) ? $team->privacy : '') }}">
            </div>
            <div class="form-group">
                <label>Invisible/Visible</label>
                <input type="text" name="feed" class="form-control" value="{{ old('feed', isset($team) ? $team->feed : '') }}">
            </div>
            <div class="form-group">
                <label >About</label>
                <textarea class="ckeditor" name="about">{{ old('about', isset($team) ? $team->about : '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="space_type_id">Space type</label>
                <?php $spaceTypes = \Illuminate\Support\Facades\DB::table('space_types')->where('status', 1)->get(); ?>
                <select name="space_type_id" class="form-control">
                    @foreach($spaceTypes as $spaceType)
                        <option @if($spaceType->id == $team->space_type_id) selected @endif value="{{$spaceType->id}}">{{$spaceType->type}}</option>
                    @endforeach
                </select>
                <p class="helper-block">
                    {{ trans('global.user.fields.email_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection