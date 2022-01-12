@extends('layouts.master')
@section('head')
<style>
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
                        <h2>JURNAL HARIAN ADM & IT</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item"><a href="#"><i class="zmdi zmdi-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">App</a></li>
                            <li class="breadcrumb-item active">Jurnal-harian</li>
                            @auth
                            <input type="hidden" id="stat" value="masuk">
                            <li class="breadcrumb-item active">{{auth()->user()->anggota->nama}}</li>
                            @else
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
                                                        <input type="text" name="jenis[]" class="form-control" placeholder="..." required>
                                                        <label class="container" style="margin-top: 10px;">Selesai
                                                            <input type="checkbox" value="selesai" name="status[]" style="margin-top: 10px;" >
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
                <div class="col-md-12 col-lg-4" style="margin-top: 58px; text-align: right;">
                    {{-- @auth
                        <a class="btn btn-round btn-sm btn-primary waves-effect" style="margin-bottom: 10px" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth --}}
                    
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
                        </div>
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
            success: function(data){
                console.log(data);
                $('#btnadd').val('SUBMIT');
                $('#btnadd').attr('disabled',false);
                $("#formaddjob")[0].reset();
                toastr.success('Success', 'Mengisi Jurnal');
            },
            error: function(data)
            {   
                console.log(data);
            }
        });
    });
</script>

@endsection