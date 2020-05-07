@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.team.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.team.fields.team_name') }}
                        </th>
                        <th>
                            Organizer
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Members
                        </th>
                        <th>
                            Created
                        </th>
                        <th>
                            Login
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $key => $team)
                        <tr data-entry-id="{{ $team->id }}">
                            <td>
                                <?php
                                    $meeting = \Illuminate\Support\Facades\DB::table('meetings')->select('created_at')->where('team_id', '=', $team->id)->latest()->first();
                                ?>
                            </td>
                            <td>
                                {{ $team->team_name ?? '' }}
                            </td>
                            <td>
                                {{ $team->owner->name ?? '' }}
                            </td>
                            <td>
                                {{ $team->owner->email ?? '' }}
                            </td>
                            
                            <td>
                                {{ count($team->members) ?? '' }}
                            </td>
                            <td>
                                {{ date('d.m.y', strtotime($team->created_at)) ?? '' }}
                            </td>
                            <td>
                                @if(!empty($meeting))
                                    {{ date('d.m.y', strtotime($meeting->created_at)) ?? '' }}
                                @else
                                    {{ date('d.m.y', strtotime($team->created_at)) ?? '' }}
                                @endif
                            </td>
                            <td>
                                
                                <a class="btn btn-xs btn-warning" href="{{ route('admin.teams.members', $team->id) }}">
                                    {{ trans('global.members') }}
                                </a>
                                @can('team_delete')
                                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
    url: "{{ route('admin.teams.massDestroy') }}",
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
@can('team_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection
@endsection