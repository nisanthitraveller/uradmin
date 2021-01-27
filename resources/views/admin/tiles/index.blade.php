@extends('layouts.admin')
@section('content')
<?php $feed = [0 => 'No', 1 => 'Yes'];?>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.tiles.create") }}">
            Add tile
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Product tiles
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable p-0 table-sm compact">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Duration
                        </th>
                        <th>
                            Created by
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tiles as $key => $tile)
                        <tr data-entry-id="{{ $tile->id }}">
                            <td>
                                
                            </td>
                            <td>
                                {{ $tile->title ?? '' }}
                            </td>
                            <td>
                                {{ $tile->category->category_name ?? '' }}
                            </td>
                            <td>
                                {{ $tile->price ?? '' }}
                            </td>
                            
                            <td>
                                {{ $tile->duration ?? '' }}
                            </td>
                            
                            <td data-sort="{{strtotime($tile->created_at)}}">
                                {{ date('d.m.y', strtotime($tile->created_at)) ?? '' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.tiles.edit', $tile->id) }}" style="margin-right: 10px">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.tiles.destroy', $tile->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a href="javascript:;" onclick="$(this).parent().submit()">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </form>
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
  
  let feedButton = {
    text: 'Enable Feed',
    url: "{{ route('admin.teams.massFeed') }}",
    className: 'btn-info',
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
          data: { ids: ids }})
          .done(function () { location.reload() })
      }
    }
  }
  
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('team_delete')
  dtButtons.push(deleteButton)
@endcan
    dtButtons.push(feedButton)
  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons, pageLength : 500 })
})

</script>
@endsection
@endsection