@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{$title}}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable p-0 table-sm compact">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $teamObj = new \App\Team();
                        $teamData = [];
                    
                        foreach($meetings as $key => $meeting1):
                            foreach($meeting1 as $meeting):
                                $teamDetails = $teamObj->where('id', $meeting->team_id)->with('members')->with('owner')->first(); 
                                $startTime = \Carbon\Carbon::parse($meeting->created_at);
                                $finishTime = \Carbon\Carbon::parse($meeting->updated_at);
                                $totalDuration = $finishTime->diffInSeconds($startTime);
                                $teamData[$key][$meeting->team_id]['meeting'][] = $totalDuration;
                                $teamData[$key][$meeting->team_id]['team_name'] = $teamDetails->team_name;
                                $teamData[$key][$meeting->team_id]['owner_name'] = $teamDetails->owner->name;
                                $teamData[$key][$meeting->team_id]['owner_email'] = $teamDetails->owner->email;
                            endforeach;
                        endforeach;
                    ?>
                        
                    @foreach($teamData as $key1 => $data1)
                        @foreach($data1 as $data)
                            <tr data-entry-id="{{ strtotime($key1) }}">

                                    <td>

                                    </td>
                                    <td data-sort="{{strtotime($key1)}}">
                                        {{ date('d.m.y', strtotime($key1)) ?? '' }}
                                    </td>
                                    <td>
                                        {{ $data['team_name'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $data['owner_name'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $data['owner_email'] ?? '' }}
                                    </td>

                                    <td data-sort="{{$totalDuration}}">
                                        <?php
                                            $totalDuration = array_sum($data['meeting']);
                                            echo gmdate('H:i', $totalDuration);
                                        ?>
                                    </td>
                                    <td></td>

                            </tr>
                        @endforeach
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

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons, pageLength : 500 })
})

</script>
@endsection
@endsection