@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Email list
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover table-condensed datatable p-0 table-sm compact">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th width="180">
                            Name
                        </th>
                        <th width="180">
                            Email
                        </th>
                        <th width="300">
                            Subject
                        </th>
                        
                        <th width="50">
                            Date
                        </th>
                        <th width="10">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emails as $key => $email)
                        <tr data-entry-id="{{ $email->id }}">
                            <td>

                            </td>
                            <td>
                                {{ substr(ucfirst(strtolower($email->user->name)), 0, 35) ?? '' }}
                            </td>
                            <td>
                                {{ substr($email->user->email, 0, 35) ?? '' }}
                            </td>
                            <td>
                                {{ substr($email->subject, 0, 100) ?? '' }}
                            </td>
                            <td data-sort="{{strtotime($email->created_at)}}">
                                {{ date('d.m.y', strtotime($email->created_at)) ?? '' }}
                            </td>
                            
                            <td>
                                
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