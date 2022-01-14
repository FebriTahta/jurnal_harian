@extends('layouts.master')
@section('head')
<style>
    @media(max-width: 800px){
        #card_jurnal{
            margin-top: 0;
            /* text-align: right; */
        }
    }
    @media(min-width: 801px){
        #card_jurnal{
            margin-top: 58px;
            /* text-align: right; */
        }
    }
    /* The container */
    .container {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 16px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    
    /* Hide the browser's default checkbox */
    .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    
    /* Create a custom checkbox */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #eee;
    }
    
    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
      background-color: rgb(250, 250, 250);
    }
    
    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
      background-color: #2196F3;
    }
    
    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    
    /* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
      display: block;
    }
    
    /* Style the checkmark/indicator */
    .container .checkmark:after {
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
    </style>
@endsection
@section('content')
    {{-- body --}}
    <section class=" page-calendar" style="max-width: 92%; margin-left: auto">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h2>JURNAL HARIAN ADM & IT</h2><?php $a = date_create("Y-MM-DD")?>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item"><a href="#"><i class="zmdi zmdi-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">App</a></li>
                            <li class="breadcrumb-item active">Jurnal-harian 
                            {{-- @foreach ($joblist as $item)
                                {{Carbon\Carbon::parse($item->start)->isoFormat('Y-m-d')}}
                            @endforeach     --}}
                            </li> 
                            @auth
                            <li class="breadcrumb-item">{{auth()->user()->anggota->nama}}</li>
                                @if ($joblist->count() == 0)
                                <li class="breadcrumb-item text-danger" id="belum_mengisi"> Anda belum mengisi jurnal hari ini</li>
                                @endif
                            <input type="hidden" id="stat" value="masuk">
                            @else
                            <li class="breadcrumb-item text-danger">Masuk untuk mengisi jurnal harian</li>
                            <input type="hidden" id="stat" value="non">
                            @endauth
                        </ul>
                    </div>            
                </div>
            </div>
            <div class="row">
                {{-- <div class="body col-md-12 col-12 m-b-10" style="text-align: right">
                    <button type="button" class="btn btn-round btn-info waves-effect" data-toggle="modal" data-target="#user">Mengisi Jurnal ?</button>
                </div> --}}
                <div class="col-md-12 col-lg-8">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            
                                <div class="card" id="dynamic">
                                    <div id="errList" class="text-uppercase"></div>
                                    <div class="header">
                                        <h2><strong>Pekerjaan </strong></h2>
                                        <ul class="header-dropdown">
                                            <li class="dropdown"> 
                                                {{-- <button type="button" @auth id="tambah" @else data-target="#user" data-toggle="modal" @endauth data-toggle="dropdown" class=" dropdown-toggle btn btn-round btn-sm btn-info waves-effect" aria-haspopup="true" aria-expanded="false" >Tambah</button> --}}
                                                @auth
                                                    <a class="btn btn-round btn-sm btn-primary waves-effect" style="margin-bottom: 10px" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                @endauth
                                                <?php $sekarang = date("d/m/Y");?>
                                            </li>
                                        </ul>
                                    </div>
                                    <form id="formaddjob">@csrf
                                    <div class="body" style="margin-bottom: 20px">
                                        <h2 class="card-inside-title">Jenis Pekerjaan ..</h2>
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        @auth
                                                            <input type="hidden" name="tanggal" id="tgl" value="{{$sekarang}}" required>
                                                        @endauth
                                                        <input list="listjenis" type="text" name="jenis[]" class="form-control" placeholder="..." required>
                                                        <datalist id="listjenis">
                                                        @foreach ($jenis as $item)
                                                            <option value="{{$item->jenis}}">{{$item->jenis}}</option>
                                                        @endforeach
                                                        </datalist>
                                                        <label class="container" style="margin-top: 10px;">Selesai
                                                            <input type="checkbox" value="selesai" name="status[]" id="status" style="margin-top: 10px;" >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                        
                                    </div>
                                    <div class="body" style="margin-bottom: 20px">
                                        <h2 class="card-inside-title">Deskripsi ..</h2>
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea rows="4" name="deskripsi[]" class="form-control no-resize" placeholder="Tulis kendala / proses yang perlu menjadi catatan..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    @auth
                                    <input type="submit" class="btn btn-info btn-round waves-effect" id="btnadd" value="SUBMIT">
                                        @else
                                    <button type="button" data-toggle="modal" data-target="#user" class="btn btn-danger btn-round waves-effect">MASUK UNTUK MENGISI JURNAL</button>
                                    @endauth
                                    </form>
                                </div>
                                
                            
                            <div class="card">
                                
                            </div>
                        </div>
                    </div>
                    <!-- #END# Textarea --> 
                </div>
                <div class="col-md-12 col-lg-4" id="card_jurnal">
                    <div id="isi_jurnal">
                        @auth
                            @if ($joblist->count() > 0)
                                @foreach ($joblist as $jlist)
                                <a href="#" data-toggle="modal" data-target="#modalupdate" data-id="{{$jlist->id}}" data-jenis="{{$jlist->jenis->jenis}}" data-deskripsi="{{$jlist->deskripsi}}" data-status="{{$jlist->status}}">
                                <div class="card">
                                    <div class="body m-b-10">
                                        <div class="event-name b-lightred row">
                                            <div class="col-3 text-center">
                                                <h4>{{date('d')}}<span>{{date('M')}}</span><span>{{date('Y')}}</span></h4>
                                            </div>
                                            <div class="col-9">
                                                <h6>{{$jlist->jenis->jenis}}</h6>
                                                <span>
                                                    @if ($jlist->deskripsi == null)
                                                        -
                                                    @else
                                                        {{$jlist->deskripsi}}
                                                    @endif
                                                </span>
                                                <address><i class="zmdi zmdi-check"></i> {{$jlist->status}}</address>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                </a>
                                @endforeach
                            @else
                            <a href="#">
                                <div class="card">
                                    <div class="body m-b-10">
                                        <div class="event-name b-lightred row">
                                            <div class="col-3 text-center">
                                                <h4>{{date('d')}}<span>{{date('M')}}</span><span>{{date('Y')}}</span></h4>
                                            </div>
                                            <div class="col-9 text-danger">
                                                <h6>Jurnal Hari Ini KOSONG</h6>
                                                <span>Anda belum mengisi jurnal hari ini</span>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </a>
                            @endif
                            
                        @else
                        <a href="#">
                            <div class="card">
                                <div class="body m-b-10">
                                    <div class="event-name b-lightred row">
                                        <div class="col-3 text-center">
                                            <h4>{{date('d')}}<span>{{date('M')}}</span><span>{{date('Y')}}</span></h4>
                                        </div>
                                        <div class="col-9 text-danger">
                                            <h6>Daftar Jurnal Hari Ini</h6>
                                            <span>masuk untuk mengisi jurnal harian anda</span>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </a>
                        @endauth
                    </div>
                </div>
            </div>        
        </div>
    </section>
    {{-- modal --}}
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

    <div class="modal fade" id="modalupdate" tabindex="" role="dialog" data-backdrop="false" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formupdatejob">@csrf    
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="defaultModalLabel">UPDATE JOB</h4>
                    </div>
                    <div class="modal-body clearfix" >
                            <div class="body" style="margin-bottom: 20px">
                                <h4 class="title">Jenis Pekerjaan ..</h4>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="id" id="id" required>
                                                @auth
                                                    <input type="hidden" name="tanggal" id="tgl" value="{{$sekarang}}" required>
                                                @endauth
                                                <input list="listjenis" id="jenis" type="text" name="jenis" class="form-control" placeholder="..." required>
                                                <datalist id="listjenis">
                                                @foreach ($jenis as $item)
                                                    <option value="{{$item->jenis}}">{{$item->jenis}}</option>
                                                @endforeach
                                                </datalist>
                                                <label class="container" style="margin-top: 10px;">Selesai
                                                    <input type="checkbox" value="selesai" name="status" style="margin-top: 10px;" >
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <hr>
                            <div class="body" style="margin-bottom: 20px">
                                <h4 class="title">Deskripsi ..</h4>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea rows="4" id="deskripsi" name="deskripsi" class="form-control no-resize" placeholder="Tulis kendala / proses yang perlu menjadi catatan..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info btn-round waves-effect" id="btnadd1" value="UPDATE">
                        <button type="button" class="btn btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                        <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal" disabled>HAPUS</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        var stat = $('#stat').val();
        
        if (stat !== 'masuk') {
            console.log(stat);
            $("#user").modal('show');       
        }else{
            console.log(stat);
        }
    });

    $(document).ready(function(){

    // $('#user_id').keyup(function(){ 
    //     var query = $(this).val();
    //     if(query != '')
    //     {
    //         var _token = $('input[name="_token"]').val();
    //         $.ajax({
    //         url:"{{ route('autocomplete.fetch') }}",
    //         method:"POST",
    //         data:{query:query, _token:_token},
    //         success:function(data){
    //         $('#countryList').fadeIn();  
    //                 $('#countryList').html(data);
    //         }
    //         });
    //     }
    // });

    // $(document).on('click', 'li', function(){  
    //     $('#country_name').val($(this).text());  
    //     $('#countryList').fadeOut();  
    // });  
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var i = 0;
        $("#tambah").click(function(e){
            e.preventDefault();
            i++;
            $("#dynamic").append('    <a><button class="btn btn-sm btn-danger remove-tr">Hapus</button><div class="body" style="margin-bottom: 20px">'
                                        +'<h2 class="card-inside-title">Jenis Pekerjaan ..</h2>'
                                        +'<div class="row clearfix">'
                                            +'<div class="col-sm-12">'
                                                +'<div class="form-group">'
                                                    +'<div class="form-line">'
                                                        +'<input type="text" name="jenis[]" class="form-control" placeholder="..." required>'
                                                        +'<label class="container" style="margin-top: 10px;">Selesai'
                                                            +'<input type="checkbox" value="selesai" name="status[]" style="margin-top: 10px;">'
                                                            +'<span class="checkmark"></span>'
                                                            +'</label>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'                   
                                    +'</div></div>'
                                
                                +'<div class="body" style="margin-bottom: 20px">'
                                    +'<h2 class="card-inside-title">Deskripsi ..</h2>'
                                    +'<div class="row clearfix">'
                                        +'<div class="col-sm-12">'
                                            +'<div class="form-group">'
                                                +'<div class="form-line">'
                                                    +'<textarea rows="4" name="deskripsi[]" class="form-control no-resize" placeholder="Tulis kendala / proses yang perlu menjadi catatan..."></textarea>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'</a>');
            
            
        });
    });
    $(document).on('click', '.remove-tr', function(e){ 
        e.preventDefault();
        // --i;
        $(this).parents('a').remove();
    });  
    $('#formaddjob').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var card_jurnalku = '';
        $.ajax({
            type:'POST',
            url: "/new_input",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#btnadd').attr('disabled','disabled');
                $('#btnadd').val('Process');
            },
            success: function(response){
                if(response.status == 200)
                {
                    $('#btnadd').val('SUBMIT');
                    $('#btnadd').attr('disabled',false);
                    $("#formaddjob")[0].reset();
                    // toastr.success('Success', 'Mengisi Jurnal');
                    toastr.success(response.message);
                    $('#errList').removeClass('alert alert-danger');
                    $('#isi_jurnal a').remove();
                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                        ];
                    $.ajax({
                        url:"jurnalku-data",
                        type: 'get',
                        dataType: 'json',
                            success:function(datas) {
                                for (let index = 0; index < datas.length; index++) {
                                    var tgl = new Date(datas[index].start);
                                    card_jurnalku = '<a style="text-black" data-toggle="modal" data-target="#modalupdate" data-id="'+datas[index].id+'" data-jenis="'+datas[index].jenis.jenis+'" data-deskripsi="'+datas[index].deskripsi+'" data-status="'+datas[index].status+'">'
                                                    +'<div class="card wewewe">'
                                                        +'<div class="body m-b-10">'
                                                            +'<div class="event-name row">'
                                                                +'<div class="col-3 text-center">'
                                                                    +'<h4>'+tgl.getDate()+'<span>'+monthNames[tgl.getMonth()]+'</span><span>'+tgl.getFullYear()+'</span></h4>'
                                                                    +'</div>'
                                                                    +'<div class="col-9">'
                                                                        +'<h6>'+datas[index].jenis.jenis+'</h6>'
                                                                        +'<p>'+datas[index].deskripsi+'</p>'
                                                                        +'<address><i class="zmdi zmdi-check"></i> '+datas[index].status+'</address>'
                                                                        +'<hr>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</a>';
                                    $('#isi_jurnal').append(card_jurnalku);
                                    $('#belum_mengisi').remove();
                                }
                            }
                    });
                }
            },
            error: function(data)
            {   
                console.log(data);
            }
        });
    });
</script>

<script>
$('#modalupdate').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var jenis = button.data('jenis')
                var deskripsi = button.data('deskripsi')
                var status = button.data('status')
                var modal = $(this)
                $('#id').val(id);
                $('#jenis').val(jenis);
                $('#deskripsi').text(deskripsi);
            })
</script>

<script>
    $('#formupdatejob').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var card_jurnalku = '';
        $.ajax({
            type:'POST',
            url: "/new_update",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#btnadd1').attr('disabled','disabled');
                $('#btnadd1').val('Process');
            },
            success: function(response){
                if(response.status == 200)
                {
                    $('#btnadd1').val('UPDATE');
                    $('#btnadd1').attr('disabled',false);
                    $("#formupdatejob")[0].reset();
                    $("#modalupdate").hide();
                    // toastr.success('Success', 'Mengisi Jurnal');
                    toastr.success(response.message);
                    // $('#errList').removeClass('alert alert-danger');
                    $('#isi_jurnal div').remove();
                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                        ];
                    $.ajax({
                        url:"jurnalku-data",
                        type: 'get',
                        dataType: 'json',
                            success:function(datas) {
                                for (let index = 0; index < datas.length; index++) {
                                    var tgl = new Date(datas[index].start);
                                    $('.wewewe').remove();
                                    card_jurnalku = '<a style="text-black;" data-toggle="modal" data-target="#modalupdate" data-id="'+datas[index].id+'" data-jenis="'+datas[index].jenis.jenis+'" data-deskripsi="'+datas[index].deskripsi+'" data-status="'+datas[index].status+'">'
                                                    +'<div class="card">'
                                                        +'<div class="body m-b-10">'
                                                            +'<div class="event-name row">'
                                                                +'<div class="col-3 text-center">'
                                                                    +'<h4>'+tgl.getDate()+'<span>'+monthNames[tgl.getMonth()]+'</span><span>'+tgl.getFullYear()+'</span></h4>'
                                                                    +'</div>'
                                                                    +'<div class="col-9">'
                                                                        +'<h6>'+datas[index].jenis.jenis+'</h6>'
                                                                        +'<p>'+datas[index].deskripsi+'</p>'
                                                                        +'<address><i class="zmdi zmdi-check"></i> '+datas[index].status+'</address>'
                                                                        +'<hr>'
                                                                        +'</div>'
                                                                        +'</div>'
                                                                        +'</a>';
                                    $('#isi_jurnal').append(card_jurnalku);
                                    $('#belum_mengisi').remove();
                                }
                            }
                    });
                }
            },
            error: function(data)
            {   
                console.log(data);
            }
        });
    });
</script>
@endsection