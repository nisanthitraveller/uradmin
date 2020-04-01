@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.team.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.team.fields.team_name') }}
                    </th>
                    <td>
                        {{ $team->team_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.team.fields.room_name') }}
                    </th>
                    <td>
                        {!! $team->room_name !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection