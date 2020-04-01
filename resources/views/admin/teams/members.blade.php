@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.members') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.team.fields.member') }}
                        </th>
                        <th>
                            {{ trans('global.email') }}
                        </th>
                        <th>
                            {{ trans('global.team.fields.organizer') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($team->members as $key => $member)
                        <?php
                            $userDetails = \App\User::where('id', $member->user_id)->select('name', 'email')->first();
                        ?>
                        <tr data-entry-id="{{ $member->id }}">
                            <td>
                                
                            </td>
                            <td>
                                {{ $userDetails->name ?? '' }}
                            </td>
                            <td>
                                {{ $userDetails->email ?? '' }}
                            </td>
                            <td>
                                @if($member->user_id == $team->created_by)
                                <i class="fas fa-check nav-icon" style="color: green">

                                    </i>
                                @endif
                            </td>
                            <td>
                                Options
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection