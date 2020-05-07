@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        VO list
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Date
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
                            Duration
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $teamObj = new \App\Team();
                    ?>
                    @foreach($meetings as $key => $meeting)
                        <tr data-entry-id="{{ $meeting->id }}">
                            <td>
                                <?php 
                                    $teamDetails = $teamObj->where('id', $meeting->team_id)->with('members')->with('owner')->first(); 
                                ?>
                            </td>
                            <td>
                                {{ date('d.m.y', strtotime($meeting->created_at)) ?? '' }}
                            </td>
                            <td>
                                {{ $teamDetails->team_name ?? '' }}
                            </td>
                            <td>
                                {{ $teamDetails->owner->name ?? '' }}
                            </td>
                            <td>
                                {{ $teamDetails->owner->email ?? '' }}
                            </td>
                            
                            <td>
                                <?php
                                    $startTime = \Carbon\Carbon::parse($meeting->created_at);
                                    $finishTime = \Carbon\Carbon::parse($meeting->updated_at);
                                    $totalDuration = $finishTime->diffInSeconds($startTime);
                                    echo gmdate('H:i', $totalDuration);
                                ?>
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