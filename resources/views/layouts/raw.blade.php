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
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="body m-b-20">
                        <div class="event-name b-lightred row">
                            <div class="col-3 text-center">
                                <h4>09<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-9">
                                <h6>Repeating Event</h6>
                                <p>It is a long established fact that a reader will be distracted</p>
                                <address><i class="zmdi zmdi-pin"></i> 123 6th St. Melbourne, FL 32904</address>
                            </div>
                        </div>
                        <hr>
                        <div class="event-name b-greensea row">
                            <div class="col-3 text-center">
                                <h4>16<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-9">
                                <h6>Repeating Event</h6>
                                <p>It is a long established fact that a reader will be distracted</p>
                                <address><i class="zmdi zmdi-pin"></i> 123 6th St. Melbourne, FL 32904</address>
                            </div>
                        </div>
                    </div>
                    <div class="body m-b-20 l-blue">
                        <div class="event-name row">
                            <div class="col-3 text-center">
                                <h4>28<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-9">
                                <h6>Google</h6>
                                <p>It is a long established fact that a reader will be distracted</p>
                                <address><i class="zmdi zmdi-pin"></i> 123 6th St. Melbourne, FL 32904</address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    @auth
        <input type="hidden" id="stat" value="masuk">
            @else
        <input type="hidden" id="stat" value="non">
    @endauth
</section>

<!-- Default Size -->
{{-- <div class="modal fade" id="addevent" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-center" role="document">
        <form id="formaddevent" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">MENGISI JURNAL</h4>
                </div>
                <div class="modal-body clearfix" >
                    <div class="form-group" id="dynamicTable">
                        <div class="row">
                            <div class="col-12 col-md-6" style=" margin-bottom: 40px">
                                <label for="">Nama</label>
                                <input list="listanggota" name="anggota_id" class="form-control" placeholder="..." id="anggota_id" required>
                                <datalist id="listanggota" style="text-transform: uppercase">
                                    @foreach ($anggota as $agt)
                                        <option style="text-transform: uppercase" value="{{$agt->nama}}">
                                    @endforeach
                                </datalist>    
                            </div>
                            <div class="col-12 col-md-6" style="margin-bottom: 40px">
                                <label for="">Bidang</label>
                                <input list="listbidang" name="bidang_id" class="form-control" placeholder="..." id="bidang_id" required>
                                <datalist id="listbidang">
                                    @foreach ($bidang as $bdg)
                                        <option value="{{$bdg->namabidang}}">
                                    @endforeach
                                </datalist>    
                            </div>
                            <div class="col-12 col-md-2" style="text-align: left;">
                                <button type="button" class="btn btn-round btn-sm btn-purple waves-effect" id="tambah">Tambah</button>
                            </div>
                            <div class="col-12 col-md-8" style="margin-bottom: 10px">
                                <input list="listjenis" name="jenis_id" class="form-control" placeholder="Pekerjaan ..." id="jenis_id" required>
                                <datalist id="listjenis">
                                    @foreach ($jenis as $jns)
                                        <option value="{{$jns->jenis}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-12 col-md-2" style="text-align: right; ">
                                <div class="checkbox">
                                    <input id="checkbox" type="checkbox">
                                    <label for="checkbox">SELESAI</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="btnhapus" class="btn btn-primary btn-round waves-effect" value="Submit">
                    <button type="button" class="btn btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

<div class="modal fade" id="user" tabindex="" role="dialog" data-backdrop="false" data-keyboard="false">
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
            $("#user").modal('show');       
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
                        // editable: true,
                        events: SITEURL + "/fullcalender",
                        displayEventTime: false,
                        // editable: true,
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
                        select: function (start, end, allDay) {
                            var oke = confirm("Mengisi Jurnal ?");
                            if (oke) {
                                // var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                // var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                $('#addevent').modal('show');
                            }

                            
                            // var title = prompt('Event Title:');
                            // if (title) {
                            //     var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                            //     var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                            //     $.ajax({
                            //         url: SITEURL + "/fullcalenderAjax",
                            //         data: {
                            //             title: title,
                            //             start: start,
                            //             end: end,
                            //             type: 'add',
                            //             eventColor: '#63a4ff',
                            //         },
                            //         type: "POST",
                            //         success: function (data) {
                            //             displayMessage("Event Created Successfully");
      
                            //             calendar.fullCalendar('renderEvent',
                            //                 {
                            //                     id: data.id,
                            //                     title: title,
                            //                     start: start,
                            //                     end: end,
                            //                     allDay: allDay,
                            //                     eventColor: '#63a4ff',
                            //                 },true);
      
                            //             calendar.fullCalendar('unselect');
                            //         }
                            //     });
                            // }
                        },
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
                                    type: 'update',
                                    eventColor: '#63a4ff',
                                },
                                type: "POST",
                                success: function (response) {
                                    displayMessage("Event Updated Successfully");
                                }
                            });
                        },
                        eventClick: function (event) {
                            var deleteMsg = confirm("Do you really want to delete?");
                            if (deleteMsg) {
                                $.ajax({
                                    type: "POST",
                                    url: SITEURL + '/fullcalenderAjax',
                                    data: {
                                            id: event.id,
                                            type: 'delete'
                                    },
                                    success: function (response) {
                                        calendar.fullCalendar('removeEvents', event.id);
                                        displayMessage("Event Deleted Successfully");
                                    }
                                });
                            }
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

    {{-- <script type="text/javascript">
        
        var i = 0;
        
        $("#tambah").click(function(e){
            e.preventDefault();
            ++i;

            $("#dynamicTable").append('');
            
        });

        $(document).on('click', '.remove-tr', function(e){ 
            e.preventDefault(); 
            $(this).parents('tr').remove();
        });  

    </script> --}}
@endsection
