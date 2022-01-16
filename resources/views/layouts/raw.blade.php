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
                <a class="btn  btn-sm waves-effect" href="/recap-jurnal" style="background-color: rgb(186, 134, 255)">
                    {{ __('Recap Jurnal') }}
                </a>
                @auth

                    <a class="btn  btn-sm waves-effect" href="/jurnal-harian" style="background-color: rgb(255, 134, 150)">
                    {{ __('Mengisi Jurnal ?') }}
                    </a>
                    
                    <a class="btn  btn-sm btn-primary waves-effect" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <button type="button" class="btn btn-round btn-sm btn-info waves-effect" data-toggle="modal" data-target="#user">Mengisi Jurnal ?</button>
                @endauth
            </div>
            {{-- <div class="header col-md-12 col-12 m-b-10" >
                <h5><strong>Pekerjaan </strong></h5>
            </div> --}}
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" id="card_jurnal_kalender">
                @if ($joblist->count() > 0)
                @foreach ($anggota as $item)
                <a href="#" data-toggle="modal" data-target="#modalmyjob" data-anggota_id="{{$item->id}}" data-tanggal="{{$isijurnal->start}}">
                    <div class="card">
                        <div class="body l-blue">
                            <div class="event-name row">
                                <div class="col-3 text-center">
                                    <h4>{{date("d",strtotime($isijurnal->start))}}<span>{{date("M",strtotime($isijurnal->start))}}</span><span>{{date("Y",strtotime($isijurnal->start))}}</span></h4>
                                </div>
                                <div class="col-9">
                                    <h6>{{$item->nama}}</h6>
                                    <p>Selesai mengisi Jurnal harian</p>
                                    <address><i class="zmdi zmdi-pin"></i>{{$item->bidang->namabidang}}</address>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @else
                <a href="#">
                <div class="card">
                    <div class="body l-red">
                        <div class="event-name row">
                            <div class="col-3 text-center">
                                <h4>{{date("d")}}<span>{{date("M")}}</span><span>{{date("Y")}}</span></h4>
                            </div>
                            <div class="col-9">
                                <h6>Jurnal Hari Ini Kosong</h6>
                                <p>Belum ada satupun anggota yang mengisi jurnal</p>
                                <address><i class="zmdi zmdi-check"></i> -</address>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                @endif
            </div>
        </div>        
    </div>

    @auth
        <input type="hidden" id="stat" value="masuk">
        <input type="hidden" id="user_id" value="{{auth()->user()->anggota_id}}">        
            @else
        <input type="hidden" id="stat" value="non">
    @endauth
</section>

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
                                @foreach ($semuaanggota as $item)
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

<div class="modal fade" id="modalmyjob" tabindex="" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        {{-- <form method="POST" action="{{ route('login') }}"> --}}
            @csrf
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="title" id="modallabel">PEKERJAAN</h4>
                </div>
                <div class="modal-body clearfix" >
                    <div class="form-group" id="joblist">
                        <div class="form-group">
                            {{-- konten --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        {{-- </form> --}}
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
                        var start   = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var show    = confirm("Menampilkan jurnal pada tanggal " + start + " ?");
                        var card_jurnal = "";
                        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                        ];
                        if (show) {
                            $.ajax({
                                contentType: false,
                                processData: false,
                                url: SITEURL + '/show/' + start,
                                data: {
                                    start: start,
                                },
                                type: "GET",
                                success: function (response) {
                                    $('#card_jurnal_kalender a').remove();
                                    
                                    var tgl = new Date(start);
                                    for (let index = 0; index < response.length; index++) {
                                    var tanggal = tgl.getDate()+'-'+monthNames[tgl.getMonth()]+'-'+tgl.getFullYear();
                                    card_jurnal='<a href="#" data-toggle="modal" data-target="#modalmyjob" data-anggota_id="'+response[index].id+'" data-tanggal="'+tanggal+'">'
                                                    +'<div class="card">'
                                                        +'<div class="body l-blue">'
                                                            +'<div class="event-name row">'
                                                                +'<div class="col-3 text-center">'
                                                                    +'<h4>'+tgl.getDate()+'<span>'+monthNames[tgl.getMonth()]+'</span><span>'+tgl.getFullYear()+'</span></h4>'
                                                                    +'</div>'
                                                                    +'<div class="col-9">'
                                                                        +'<h6>'+response[index].nama+'</h6>'
                                                                        +'<p>Selesai mengisi Jurnal harian</p>'
                                                                        +'<address><i class="zmdi zmdi-pin"></i>'+response[index].bidang.namabidang+'</address>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</a>'
                                        console.log(response[index].id);
                                        $('#card_jurnal_kalender').append(card_jurnal);
                                    }
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

    <script>
        $('#modalmyjob').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var anggota_id = button.data('anggota_id')
                var tanggal = button.data('tanggal')
                var modal = $(this)
                console.log(tanggal);
                // modal.find('.modal-body #id').val(id);
                $.ajax({
                                contentType: false,
                                processData: false,
                                url: '/show-my-job/'+anggota_id+'/'+tanggal,
                                data: {
                                    anggota_id: anggota_id,
                                    tanggal: tanggal,
                                },
                                type: "GET",
                                success: function (response) {
                                    $('#joblist a').remove();
                                    for (let index = 0; index < response.length; index++) {
                                    console.log(response[index].id);
                                    var nomor = index+1;
                                    var card_jurnal='<a href="#">'
                                                        +'<div class="card">'
                                                            +'  <div class="body l-red">'
                                                                +'  <div class="event-name row">'
                                                                    
                                                                    +'  <div class="col-12">'
                                                                        +'  <h6>'+nomor+'. '+response[index].jenis.jenis+'</h6>'
                                                                        +'<p>'+response[index].deskripsi+'</p>'
                                                                        +'<address><i class="zmdi zmdi-check"></i>'+response[index].status+'</address>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</a>'
                                    $('#joblist').append(card_jurnal);
                                    }
                                }
                            });
            })
    </script>
@endsection
