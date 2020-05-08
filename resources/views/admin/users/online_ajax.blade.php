<?php
$status = [1 => 'user-active', 2 => 'user-offline', 3 => 'user-in-meeting', 4 => 'user-personal-work', 5 => 'user-deep-work', 6 => 'user-active'];
?>
@foreach($users as $key => $user)
<?php
$memberCount = 0;
$query = "SELECT m.*, t.team_name FROM meetings m LEFT JOIN teams t ON t.id = m.team_id where m.user_id = {$user->id} order by m.created_at desc limit 1";
$userStatus = \Illuminate\Support\Facades\DB::select($query);
$query2 = "SELECT m.* from meetings m where m.user_id = {$user->id} AND DATE(created_at) = '".date('Y-m-d')."' order by m.created_at ASC limit 1";
$userStatus2 = \Illuminate\Support\Facades\DB::select($query2);
?>
<tr data-entry-id="{{ $user->id }}">
    <td>

    </td>
    <td>
        {{ $user->name ?? '' }}
    </td>
    <td>
        {{ $user->email ?? '' }}
    </td>
    <td data-sort="{{strtotime($user->created_at)}}">
        {{ date('d.m.y', strtotime($user->created_at)) ?? '' }}
    </td>
    <td>
        {{ \Carbon\Carbon::parse(strtotime($userStatus2[0]->created_at))->setTimezone($user->timezone)->format('d.m.y H:i:s') }}
    </td>
    <td>
        <span class="user-active {{$status[$user->status]}}"></span>
    </td>
    <td>
        @if($user->status == 3)
        Meeting {{$userStatus[0]->team_name}}
        @elseif($user->status == 6)
        VO {{$userStatus[0]->team_name}}
        @elseif($user->status == 1)
        Online
        @elseif($user->status == 4)
        Personal work
        @elseif($user->status == 5)
        Deep work {{$userStatus[0]->team_name}}
        @endif
    </td>
    <td>
        @can('user_show')
        <a href="{{ route('admin.users.show', $user->id) }}">
            <i class="fa fa-search"></i>
        </a>
        @endcan
        @can('user_edit')
        <a href="{{ route('admin.users.edit', $user->id) }}">
            <i class="fa fa-pencil"></i>
        </a>
        @endcan
        @can('user_delete')
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a href="javascript:;" onclick="$(this).parent().submit()">
                <i class="fa fa-trash"></i>
            </a>
        </form>
        @endcan

    </td>
</tr>
@endforeach