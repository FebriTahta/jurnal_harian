@extends('layouts.master')
@section('content')


<section class=" page-calendar" style="max-width: 92%; margin-left: auto">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>JURNAL HARIAN ADM & IT</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="#"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">App</a></li>
                        <li class="breadcrumb-item active">Calendar</li>
                        @auth
                        <li class="breadcrumb-item active">{{auth()->user()->anggota->nama}}</li>
                        @endauth
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row">
            <div class="body col-md-12 col-12 m-b-10" style="text-align: right">
                @auth
                    <a class="btn btn-round btn-primary waves-effect" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <button type="button" class="btn btn-round btn-info waves-effect" data-toggle="modal" data-target="#user">Mengisi Jurnal ?</button>
                @endauth
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 col-lg-4" id="card_jurnal_kalender">
                
                @foreach ($anggota as $items)
                <a href="#">
                <div class="card">
                    <div class="body m-b-20">
                        @foreach ($items->joblist as $item)
                            <div class="event-name b-lightred row">
                                <div class="col-3 text-center">
                                    <h4><span>{{Carbon\Carbon::parse($item->start)->isoFormat('Y mm dd')}}</span><span></span></h4>
                                </div>
                                <div class="col-9">
                                    <h6>{{strtoupper($item->anggota->nama).' - '.$item->jenis->jenis}}</h6>
                                    <span>{{$item->deskripsi}}</span>
                                    <address><i class="zmdi zmdi-check"></i> {{$item->status}}</address>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
                </a>
                @endforeach
            </div>
        </div>        
    </div>

    @auth
        <input type="hidden" id="stat" value="masuk">
            @else
        <input type="hidden" id="stat" value="non">
    @endauth
</section>

{{-- <div class="modal fade" id="user" tabindex="" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">MASUK SEBAGAI</h4>
                </div>
                <div class="modal-body clearfix" >
                    <div class="form-group" id="dynamicTable">
                        <div class="form-group">
                            <select class="form-control show-tick" name="username" style="text-transform: uppercase" required>
                                <option value="">Nama ..</option>
                                @foreach ($anggota as $item)
                                    <option style="text-transform: uppercase" value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>

                            <input type="password" value="adm" name="password" style="display: none">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn modal-col-pink btn-round waves-effect" value="Submit">
                    <button type="button" class="btn btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

<div class="modal fade" id="user1" tabindex="" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">FITUR KALENDER & DOKUMENTASI</h4>
                </div>
                <div class="modal-body clearfix" >
                    <div class="form-group" id="dynamicTable">
                        <div class="form-group">
                            <p>Sedang dalam pengembangan</p>

                            <input type="password" value="adm" name="password" style="display: none">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/jurnal-harian" class="btn modal-col-pink btn-round waves-effect"> Mengisi Jurnal!</a>
                    {{-- <input type="submit" class="btn modal-col-pink btn-round waves-effect" value="Submit"> --}}
                    {{-- <button type="button" class="btn btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button> --}}
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).keypress(
    function(event){
        if (event.which == '13') {
        event.preventDefault();
        }
    });
    $(document).ready(function(){
        var stat = $('#stat').val();
        
        if (stat !== 'masuk') {
            console.log(stat);
            $("#user1").modal('show');       
        }else{
            console.log(stat);
        }
    });
</script>

<script>
    $(document).ready(function () {
       
    var SITEURL = "{{ url('/') }}";
      
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
    var calendar = $('#calendar').fullCalendar({
                    eventColor: '#63a4ff',
                    editable: true,
                    events: SITEURL + "/fullcalender",
                    displayEventTime: false,
                    editable: true,
                    eventTextColor: '#fff',
                    eventBorderColor: 'red',
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                                event.allDay = true;
                        } else {
                                event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    // select: function (start, end, allDay) {
                    //     var title = prompt('Event Title:');
                    //     if (title) {
                    //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                    //         $.ajax({
                    //             url: SITEURL + "/fullcalenderAjax",
                    //             data: {
                    //                 title: title,
                    //                 start: start,
                    //                 end: end,
                    //                 type: 'add'
                    //             },
                    //             type: "POST",
                    //             success: function (data) {
                    //                 displayMessage("Event Created Successfully");
  
                    //                 calendar.fullCalendar('renderEvent',
                    //                     {
                    //                         id: data.id,
                    //                         title: title,
                    //                         start: start,
                    //                         end: end,
                    //                         allDay: allDay
                    //                     },true);
  
                    //                 calendar.fullCalendar('unselect');
                    //             }
                    //         });
                    //     }
                    // },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
  
                        $.ajax({
                            url: SITEURL + '/fullcalenderAjax',
                            data: {
                                title: event.title,
                                start: start,
                                end: end,
                                id: event.id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                                displayMessage("Event Updated Successfully");
                            }
                        });
                    },
                    eventClick: function (event) {
                        // var deleteMsg = confirm("Do you really want to delete?");
                        // if (deleteMsg) {
                        //     $.ajax({
                        //         type: "POST",
                        //         url: SITEURL + '/fullcalenderAjax',
                        //         data: {
                        //                 id: event.id,
                        //                 type: 'delete'
                        //         },
                        //         success: function (response) {
                        //             calendar.fullCalendar('removeEvents', event.id);
                        //             displayMessage("Event Deleted Successfully");
                        //         }
                        //     });
                        // }
                    }
 
                });
 
});
     
    function displayMessage(message) {
        toastr.success(message, 'Event');
    } 
      
    </script>

    <script>
    $('#formaddevent').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "/new_input",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#btnhapus').attr('disabled','disabled');
                $('#btnhapus').val('Process');
            },
            success: function(data){
                $('#btnhapus').val('Add');
                $('#btnhapus').attr('disabled',false);
                $('#addevent').modal('hide');
                toastr.success('ok', 'Event');

                var calendar = $('#calendar').fullCalendar({
                    eventColor: '#63a4ff',
                    editable: true,
                    events: "/fullcalender",
                    displayEventTime: false,
                    editable: true,
                    eventTextColor: '#fff',
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,                                                        
                });
                calendar.fullCalendar('renderEvent',
                {
                    id: data.id,
                    title: data.title,
                    start: data.start,
                    end: data.end,
                    eventColor: '#63a4ff',
                },true);
                calendar.fullCalendar('unselect');
                                                
            },
            error: function(data)
            {
                console.log(data);
            }
        });
    });
    </script>
@endsection
