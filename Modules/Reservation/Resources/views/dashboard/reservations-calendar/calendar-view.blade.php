@push('styles')
<link rel="stylesheet"
  href="{{ asset('admin/calendar/main.min.css') }}" />

<style>
  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
    text-transform: capitalize;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

  .fc .fc-timegrid-slot {
    height: 5.5em;
    border-bottom: 0;
  }

</style>
@endpush
<div id='calendar'></div>
@include('reservation::dashboard.parts.reserve-calendar-modal')


@push('scripts')
<script src="{{ asset('admin/calendar/main.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  var lawyerId, calendarEventHandler;

let header = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
calendarEventHandler = $("#lawyer_id").on("change", function () {
    let services = $(this).find(":selected").data('services');
    $.each(services, function (key, value) {
        $('#service_id').append(`<option value="${value.id}">${value.title}</option>`);
    })
    lawyerId = $(this).val();
    let eventObject = {
        url: "{{ route('dashboard.reservations_calendar.by_date') }}",
        extraParams: {
            lawyer_id: lawyerId
        },
        method: "get",
        failure: function () {
            alert("there was an error while fetching events!");
        },
        color: "yellow", // a non-ajax option
        textColor: "black", // a non-ajax option
    };

    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'UTC',
        allDaySlot: false,
        locale: "{{ locale() }}", // the initial locale
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        initialView: "timeGridWeek",
        select: function (arg) {
            handelDialog(arg, calendar)
        },
        eventClick: function (arg) {
            if (arg.event.extendedProps.deletable) {
                handelDelete(arg)
            }
        },
        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events
        slotDuration: "01:00:00",
        slotLabelInterval: "01:00:00",
        events: eventObject,
        eventOverlap: false,
        eventMouseEnter: function (info) {
            $(info.el).tooltip({
                html: true,
                title: renderEventShow(info.event),
                placement: "left",
                trigger: "hover",
                container: "body",
            });
        },
    });
    calendar.render();

});
calendarEventHandler.change()
function renderEventShow(event) {
    let extendedProps = event.extendedProps;
    if (extendedProps.deletable) {
        return `
            <div class="card"
            style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">${extendedProps.creator.name}</h5>
                <h5 class="card-title">${extendedProps.creator.lawyer}</h5>
                <h5 class="card-title">${extendedProps.creator.service}</h5>
                    </div>
                    </div>`

    }
}

function handelDialog(args, calendar) {
    $('#event-modal').modal('show')
    $('#confirm').click(function (e) {
        e.preventDefault();
        let data = {};
        let user_id = $('#userIdField').val()
        // let name = $('#nameField').val()
        // let mobile = $('#moblieField').val()
        data["lawyer_id"] = $("#lawyer_id").val();
        data["user_id"] = user_id;
        // data["name"] = name;
        // data["mobile"] = mobile;
        data['service_id'] = $('#service_id').val();
        data["payment_method"] = "calendar";
        data["date"] =(args["startStr"].split('T'))[0];
        data["start"] =args['startStr'];
        data["end"] =args['endStr'];
        let url = "{{ route('dashboard.reservations_calendar.store') }}"

        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.progress-bar').width(percentComplete + '%');
                        $('#progress-status').html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            type: "post",
            url: url,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $('#confirm').prop('disabled', true);
                $('.progress-info').show();
                $('.progress-bar').width('0%');
                resetErrors();
            },
            success:  (data)=> {
                $('#event-modal').modal('hide')
                $('#confirm').prop('disabled', false);
                $('#submit').text();
                if (data[0] == true) {
                    successfully(data);
                    calendar.unselect();
                    calendar.addEvent({
                      title: name,
                      start: args.start,
                      end: args.end,
                      allDay: args.allDay,
                      color: "yellow", // a non-ajax option
                      textColor: "black", // a non-ajax option
                      extendedProps: {
                      deletable: true
                      , }
                    , });
                } else {
                    displayMissing(data);
                };
            },
            error: function (data) {
                $('#confirm').prop('disabled', false);
                displayErrors(data);
            },
        });

    })

}



function handelDelete(arg) {
    let event = arg.event
    let url = '{{ route('dashboard.reservations_calendar.delete') }}'
     bootbox.confirm({
      message: '{{ __('apps::dashboard.messages.delete') }}',
      buttons: {
        confirm: {
          label: '{{ __('apps::dashboard.buttons.yes') }}',
          className: 'btn-success'
        },
        cancel: {
          label: '{{ __('apps::dashboard.buttons.no') }}',
          className: 'btn-danger'
        }
      },
      callback: function(result) {
        if (result) {
          $.ajax({
            method: 'POST',
            url: url,
            data: {'id': event.id},
            success: (msg)=> {
              toastr["success"](msg[1]);
              arg.event.remove()
            },
            error: function(msg) {
              toastr["error"](msg[1]);

            }
          });

        }
      }
    });
}
</script>
@endpush
