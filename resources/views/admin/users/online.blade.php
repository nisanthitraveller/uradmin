@extends('layouts.admin')
@section('content')
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.users.create") }}">
            {{ trans('global.add') }} {{ trans('global.user.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover table-condensed datatable p-0 table-sm compact">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.email') }}
                        </th>

                        <th>
                            Signup
                        </th>
                        <th>
                            Login time
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Space
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody id="userList">
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
            text: deleteButtonTrans,
                    url: "{{ route('admin.users.massDestroy') }}",
                    className: 'btn-danger',
                    action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                    });
                    if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                    headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                    }
            }
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_delete')
            dtButtons.push(deleteButton)
            @endcan

            $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons, pageLength : 500 })
            $('[data-toggle="tooltip"]').tooltip();
    })
    setInterval(function () {
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            type: 'GET',
            url: '/admin/onlineusers',
            headers: {"x-csrf-token": token},
            dataType: 'JSON',
            success: function (data) {
                $('#userList').html(data.html);
            }
        });
    }, 10000);
</script>
@endsection
@endsection