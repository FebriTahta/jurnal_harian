@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<style>
    table.dataTable tbody td {
  vertical-align: top;
}
</style>
@endsection

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
                <a class="btn  btn-sm waves-effect" href="/jurnal-harian" style="background-color: rgb(255, 134, 150)">
                    {{ __('Mengisi Jurnal ?') }}
                </a>
                @auth
                    <a  class="btn  btn-sm btn-primary waves-effect" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <button type="button" class="btn btn-sm btn-info waves-effect" data-toggle="modal" data-target="#user">Masuk ?</button>
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
                        <div class="form-group" style="margin-bottom: 20px">
                            <select class="form-control show-tick" name="bidang" style="text-transform: uppercase" required>
                                <option value="">Bidang ..</option>
                                @foreach ($bidang as $item)
                                    <option style="text-transform: uppercase" value="{{$item->id}}">{{$item->namabidang}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style="display: none" id="block_username">
                            <div class="body">
                                {{-- <div class="form-group">
                                    <div class="radio inlineblock m-r-20">
                                        <input type="radio" name="gender" id="male" class="with-gap" value="option1">
                                        <label for="male">Male</label>
                                    </div>                                
                                    <div class="radio inlineblock">
                                        <input type="radio" name="gender" id="Female" class="with-gap" value="option2">
                                        <label for="Female">Female</label>
                                    </div>
                                </div> --}}
                                <div class="table-responsive">
                                    <table class="table data-table table-bordered table-stripped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%">No</th>
                                                {{-- <th style="width: 15%">PILIH</th> --}}
                                                <th>NAMA</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="width: 15%">No</th>
                                                {{-- <th style="width: 15%">PILIH</th> --}}
                                                <th>NAMA</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{-- <select class="form-control show-tick" name="username" id="username" style="text-transform: uppercase;" required>
                                <option value="">Nama ..</option>
                                @foreach ($semuaanggota as $item)
                                    <option style="text-transform: uppercase" value="{{$item->nama}}">{{$item->nama}}</option>
                                @endforeach
                            </select> --}}
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

<div class="modal fade" id="modal_hapus" tabindex="" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        {{-- <form method="POST" action="{{ route('login') }}"> --}}
            @csrf
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="title">PEKERJAAN</h4>
                </div>
                <div class="modal-body clearfix" >
                    <div class="form-group">
                        <div class="form-group">
                            <p>Yakin akan menghapus Pekerjaan ini ?</p>
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

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>

<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script><!-- Custom Js --> 
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

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


<script>
    $('select[name="bidang"]').on('change', function() {
	var bidang_id = $(this).val();
	document.getElementById('block_username').style.display="";
    $('.check').click(function() {
                $('.check').not(this).prop('checked', false);
                console.log('yaaa');
            });
	if(bidang_id) {
        console.log(bidang_id);
		// $.ajax({
		// 	url: '/fetch_username_from_bidang/' + bidang_id,
		// 	type: "GET",
		// 	dataType: "json",
		// 	success:function(response) {                      
        //         // $.each(data, function(id, nama) {
        //         //     console.log(data);
                    
		// 		// });
        //         $('#block_username a').remove();
        //         for (let index = 0; index < response.length; index++) {
        //                             console.log(response[index].id);
        //                             var nomor = index+1;
        //                             var card_jurnal='<a href="#">'
        //                                                 +'<div class="card">'
        //                                                     +'  <div class="body l-red">'
        //                                                         +'  <div class="event-name row">'
                                                                    
        //                                                             +'  <div class="col-12">'
        //                                                                 +'<div class="checkbox"><input id="remember_me'+nomor+'" name="username" class="check" type="checkbox"><label for="remember_me'+nomor+'">Remember Me</label></div>'
        //                                                                 +'<p></p>'
        //                                                                 +'<address><i class="zmdi zmdi-check"></i></address>'
        //                                                                 +'</div>'
        //                                                                 +'</div>'
        //                                                                 +'</div>'
        //                                                                 +'</div>'
        //                                                                 +'</a>'
        //                             $('#block_username').append(card_jurnal);
        //                             }
        //     // $('.check').click(function() {
        //     //     $('.check').not(this).prop('checked', false);
        //     //     console.log('yaaa');
        //     // });
		// 	}
		// });
        
        $('.data-table').DataTable({
                //karena memakai yajra dan template maka di destroy dulu biar ga dobel initialization
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url:'/fetch_username_from_bidang/'+bidang_id,
                },
                columns: [
                    {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                    data:'check',
                    name:'nama'
                    },
                    // {
                    // data:'nama',
                    // name:'nama'
                    // },
                    
                ]
            });
            $('.check .data-table').click(function() {
                $('.check').not(this).prop('checked', false);
                console.log('yaaa');
            });
            
	}else{
		// $('select[name="username"]').empty().disabled();
	}
})
</script>

<script>
    // $("input:checkbox").on('click', function() {
    // // in the handler, 'this' refers to the box clicked on
    // var $box = $(this);
    // if ($box.is(":checked")) {
    //     // the name of the box is retrieved using the .attr() method
    //     // as it is assumed and expected to be immutable
    //     var group = "input:checkbox[name='" + $box.attr("name") + "']";
    //     // the checked state of the group/box on the other hand will change
    //     // and the current value is retrieved using .prop() method
    //     $(group).prop("checked", false);
    //     $box.prop("checked", true);
    // } else {
    //     $box.prop("checked", false);
    // }
    // });
    
</script>

@endsection
