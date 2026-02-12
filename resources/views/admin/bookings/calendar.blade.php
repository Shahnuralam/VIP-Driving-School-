@extends('adminlte::page')

@section('title', 'Bookings Calendar')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Bookings Calendar</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> List View
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- Booking Details Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tr>
                        <th>Reference:</th>
                        <td id="modal-reference"></td>
                    </tr>
                    <tr>
                        <th>Customer:</th>
                        <td id="modal-customer"></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td id="modal-email"></td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td id="modal-phone"></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td id="modal-status"></td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td id="modal-amount"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" id="modal-view-link" class="btn btn-primary">View Details</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
#calendar {
    max-width: 100%;
}
.fc-event {
    cursor: pointer;
}
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '{{ route('admin.bookings.calendar.events') }}',
        eventClick: function(info) {
            var event = info.event;
            var props = event.extendedProps;
            
            document.getElementById('modal-reference').textContent = props.reference;
            document.getElementById('modal-customer').textContent = event.title.split(' - ')[0];
            document.getElementById('modal-email').textContent = props.customer_email;
            document.getElementById('modal-phone').textContent = props.customer_phone || 'N/A';
            document.getElementById('modal-status').innerHTML = '<span class="badge badge-' + getStatusColor(props.status) + '">' + props.status.charAt(0).toUpperCase() + props.status.slice(1) + '</span>';
            document.getElementById('modal-amount').textContent = props.amount;
            document.getElementById('modal-view-link').href = '/admin/bookings/' + event.id;
            
            $('#bookingModal').modal('show');
        },
        eventDidMount: function(info) {
            $(info.el).tooltip({
                title: info.event.extendedProps.reference,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        }
    });
    
    calendar.render();
    
    function getStatusColor(status) {
        switch(status) {
            case 'pending': return 'warning';
            case 'confirmed': return 'info';
            case 'completed': return 'success';
            case 'cancelled': return 'danger';
            default: return 'secondary';
        }
    }
});
</script>
@stop
