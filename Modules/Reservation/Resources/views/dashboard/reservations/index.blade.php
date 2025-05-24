@extends('apps::dashboard.layouts.app')
@section('title', __('reservation::dashboard.reservations.routes.index'))
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{__('reservation::dashboard.reservations.routes.index')}}</a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="mb-2 p-2"><p></p></div>
        <div class="mb-3 mt-3">
          <button class="btn sbold green" type="button" id="reserve">
            <i class="fa fa-plus"></i> {{ trans('reservation::dashboard.reservations_calendar.form.title') }}
          </button>
        </div>
        <div class="portlet light bordered">
          <div class="row">
            <div class="portlet box grey-cascade">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-gift"></i>
                  {{__('apps::dashboard.datatable.search')}}
                </div>
                <div class="tools">
                  <a href="javascript:;"
                    class="collapse"
                    data-original-title=""
                    title=""> </a>
                </div>
              </div>
              <div class="portlet-body">
                <div id="filter_data_table">
                  <div class="panel-body">
                    <form id="formFilter"
                      class="horizontal-form">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="control-label">
                                {{__('apps::dashboard.datatable.form.date_range')}}
                              </label>
                              <div id="reportrange"
                                class="btn default form-control">
                                <i class="fa fa-calendar"></i> &nbsp;
                                <span> </span>
                                <b class="fa fa-angle-down"></b>
                                <input type="hidden"
                                  name="from">
                                <input type="hidden"
                                  name="to">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="control-label">
                                {{__('apps::dashboard.datatable.form.status')}}
                              </label>
                              <div class="mt-radio-list">
                                <label class="mt-radio">
                                  {{__('apps::dashboard.datatable.form.active')}}
                                  <input type="radio"
                                    value="1"
                                    name="status" />
                                  <span></span>
                                </label>
                                <label class="mt-radio">
                                  {{__('apps::dashboard.datatable.form.unactive')}}
                                  <input type="radio"
                                    value="0"
                                    name="status" />
                                  <span></span>
                                </label>
                              </div>
                            </div>
                          </div>
                          @include('reservation::dashboard.reservations.filters')
                        </div>
                      </div>
                    </form>
                    <div class="form-actions">
                      <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                        id="search">
                        <i class="fa fa-search"></i>
                        {{__('apps::dashboard.datatable.search')}}
                      </button>
                      <button class="btn btn-sm red btn-outline filter-cancel">
                        <i class="fa fa-times"></i>
                        {{__('apps::dashboard.datatable.reset')}}
                      </button>
                    </div>
                    @include('apps::dashboard.components.datatable.show-deleted-btn')
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- END DATATABLE FILTER --}}


          <div class="portlet-title">
            <div class="caption font-dark">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject bold uppercase">
                {{__('reservation::dashboard.reservations.routes.index')}}
              </span>
            </div>
          </div>

          {{-- DATATABLE CONTENT --}}
          <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover"
              id="dataTable">
              <thead>
                <tr>
                  <th>
                    <a href="javascript:;"
                      onclick="CheckAll()">
                      {{__('apps::dashboard.buttons.select_all')}}
                    </a>
                  </th>
                  <th>#</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.service')}}</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.lawyer')}}</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.reservation_date')}}</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.reservation_time')}}</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.user')}}</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.paid.title')}}</th>
                  <th>{{__('reservation::dashboard.reservations.datatable.options')}}</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="row">
            <div class="form-group">
              <button type="submit"
                id="deleteChecked"
                class="btn red btn-sm"
                onclick="deleteAllChecked('{{ url(route('dashboard.reservations.deletes')) }}')">
                {{__('apps::dashboard.datatable.delete_all_btn')}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('reservation::dashboard.parts.reserve-modal')
@stop

@section('scripts')
<script>
  function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.reservations.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[1, "desc"]],

                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'service', className: 'dt-center'  , orderable: false},
                        {data: 'lawyer', className: 'dt-center', orderable: false},
                        {data: 'reservation_date', className: 'dt-center', orderable: true},
                        {data: 'times', className: 'dt-center', orderable: false},
                        {data: 'user', className: 'dt-center', orderable: false},
                        {data: 'paid', className: 'dt-center'},
                        {data: 'id', responsivePriority: 1},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },
                        {
                            targets: -1,
                            width: '13%',
                            title: '{{__('reservation::dashboard.reservations.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Edit
                                var showUrl = '{{ route("dashboard.reservations.show",":id")}}'.replace(':id', data);

                                // Delete
                                var deleteUrl = '{{ route("dashboard.reservations.destroy", ":id") }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                @can('show_reservations')
                                            <a href="` + showUrl + `" class="btn btn-sm blue" title="Edit">
                                              <i class="fa fa-eye"></i>
                                            </a>
                                @endcan
                                @can('delete_reservations')
                                                @csrf
                                            <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                        <i class="fa fa-trash"></i>
                                      </a>
                                @endcan
                                    `;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });

        $("body").on("click", "#reserve", function()
        {
          $(".modal").modal("show")
          $("#userIdField option:selected").prop("selected", false)
          $("#lawyerIdField option:selected").prop("selected", false)
        })

        $("body").on("change", "#lawyerIdField", function()
        {
          $("#date-div").show()
          $('#serviceIdField').find('option').remove()
          $("#date").val(' ')
          $("#times").html('')

          var lawyer_id_in_dropdown = $('option:selected', this).attr('data-id');

          $("#date").attr("data-lawyer-id", lawyer_id_in_dropdown);
          $("#lawyer_id_hidden").val(lawyer_id_in_dropdown);

          $('#serviceIdField').append($('<option></option>'))

          $.get('{{route("dashboard.lawyers.ajax.services")}}?id='+lawyer_id_in_dropdown, function(data)
          {
            $('#serviceIdField').append(data['html'])
          })
        })

        $("body").on("input", "#date", function()
        {
          var data_lawyer_id = $("#lawyer_id_hidden").val();
          var selected_date = $(this).val();
          $.get('{{route("dashboard.lawyers.ajax.avaiable_times")}}?id='+data_lawyer_id+'&date='+selected_date, function(data)
          {
            $("#times").html(data['html'])
          })
        })
</script>

@stop
