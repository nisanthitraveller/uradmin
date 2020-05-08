<?php
$userObj = new \App\User();
$teamObj = new \App\Team();
$status = [1 => 'user-active', 2 => 'user-offline', 3 => 'user-in-meeting', 4 => 'user-personal-work', 5 => 'user-deep-work', 6 => 'user-active'];
?>
@foreach($users as $key => $user)
<?php
$teams = $userObj->getTeams($user->id);
$memberCount = 0;
$teamCount = 0;
foreach ($teams as $team) {
    $teamDetails = $teamObj->where('id', $team->team_id)->with('members')->with('owner')->first();
    if (!empty($teamDetails->members) && $teamDetails->status == 1 && isset($teamDetails->owner->name)) {
        if ($teamDetails->created_by == $user->id) {
            $teamCount++;
        }
        foreach ($teamDetails->members as $member) {
            $memberCount++;
        }
    }
}
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
        {{ $teamCount }}
    </td>
    <td>
        {{ $memberCount }}
    </td>
    <td>
        {{ $user->remarks ?? '' }}
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
        <span class="user-active {{$status[$user->status]}}"></span>
    </td>

</tr>
@endforeach