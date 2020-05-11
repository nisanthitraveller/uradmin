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
                        <th width="180">
                            {{ trans('global.user.fields.name') }}
                        </th>
                        <th width="180">
                            {{ trans('global.user.fields.email') }}
                        </th>
                        
                        <th width="50">
                            Signup
                        </th>
                        <th width="40">
                            Teams
                        </th>
                        <th width="40">
                            People
                        </th>
                        <th width="370">
                            Remarks
                        </th>
                        <th width="70">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $userObj = new \App\User();
                        $teamObj = new \App\Team();
                    ?>
                    @foreach($users as $key => $user)
                        <?php 
                            $teams = $userObj->getTeams($user->id);
                            $memberCount = 0;
                            $teamCount = 0;
                            foreach($teams as $team) {
                                $teamDetails = $teamObj->where('id', $team->team_id)->with('members')->with('owner')->first();
                                if(!empty($teamDetails->members) && $teamDetails->status == 1 && isset($teamDetails->owner->name)) {
                                    if($teamDetails->created_by == $user->id) {
                                        $teamCount ++;
                                    }
                                    foreach($teamDetails->members as $member) {
                                        $memberCount ++;
                                    }
                                }
                            }
                        ?>
                        <tr data-entry-id="{{ $user->id }}">
                            <td>

                            </td>
                            <td>
                                {{ substr(ucfirst(strtolower($user->name)), 0, 35) ?? '' }}
                            </td>
                            <td>
                                {{ substr($user->email, 0, 35) ?? '' }}
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
                                <a href="{{ route('admin.users.mail', ['userId' => $user->id]) }}" style="margin-right: 10px">
                                        <i class="fa fa-envelope-square"></i>
                                    </a>
                                @endcan
                                @can('user_edit')
                                    <a href="{{ route('admin.users.edit', $user->id) }}" style="margin-right: 10px">
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

</script>
@endsection
@endsection