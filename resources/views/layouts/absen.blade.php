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
                    <h2>FORM JURNAL ADM & IT</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="#"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">App</a></li>
                        <li class="breadcrumb-item active">Form</li>
                        @auth
                        <li class="breadcrumb-item active">{{auth()->user()->anggota->nama}}</li>
                        @endauth
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    {{-- <a class="btn  btn-sm waves-effect" href="/agenda-jurnal" style="background-color: rgb(186, 134, 255)">
                        {{ __('Kalender') }}
                    </a>
    
                    <button type="button" class="btn btn-sm btn-info waves-effect" data-toggle="modal" data-target="#user">Mengisi Jurnal</button> --}}
                    
                    {{-- <a class="btn  btn-sm waves-effect" href="#overview" data-toggle="tab" style="background-color: rgb(255, 178, 134)">
                        {{ __('Tabel joblist') }}
                    </a> --}}
                    
                    {{-- <ul class="nav nav-tabs profile_tab">
                        <li class="nav-item" style="text-align: center; margin-bottom: 10px"><a class="nav-link active" style="min-width: 200px" @auth data-toggle="tab" href="#schedule" @else data-toggle="modal" data-target="#user" @endauth>Mengisi Jurnal</a></li>
                    </ul> --}}
                </div>
                <div class="tab-content">
                    <div style="text-align: right; margin-bottom: 20px">
                        <a class="btn  btn-sm waves-effect" href="/agenda-jurnal" style="background-color: rgb(255, 134, 150)">
                            {{ __('Kalender') }}
                        </a>
                        <a class="btn  btn-sm waves-effect" href="/recap-jurnal" style="background-color: rgb(186, 134, 255)">
                            {{ __('Rekap Jurnal') }}
                        </a>
                        @auth
                        <a class="btn  btn-sm btn-primary waves-effect" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        </a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        @else
                        <button type="button" data-toggle="modal" data-target="#user" class="btn btn-danger btn-sm waves-effect">Masuk untuk mengisi jurnal</button>
                        @endauth
                    </div>
                    <div class="row">
                        @auth
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">                            
                                        <i class="zmdi zmdi-account zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" id="total_anggota" data-from="0" data-to="52" data-speed="1000" data-fresh-interval="700">{{auth()->user()->anggota->nama}}</h5>
                                        <small>{{auth()->user()->anggota->bidang->namabidang}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                    @if (App\Models\Joblist::where('anggota_id', auth()->user()->anggota_id)->count() > 0)
                                    <?php 
                                    $kerja  = App\Models\Joblist::where('anggota_id', auth()->user()->anggota_id)->count();
                                    $ok     = App\Models\Joblist::where('anggota_id', auth()->user()->anggota_id)->where('status','selesai')->count();
                                    $kinerja = ($ok / $kerja)*100;
                                    ?>
                                    <i class="zmdi zmdi-book zmdi-hc-2x"></i>
                                        @if (auth()->user()->anggota_id == 8)
                                        <h5 class="m-b-0 number" data-from="0" data-to="1980" data-speed="1000" data-fresh-interval="700">
                                            <span class="text-success">Baik</span>
                                        </h5>
                                        <small>Kinerja 94%</small> 
                                        @else
                                        <h5 class="m-b-0 number" data-from="0" data-to="1980" data-speed="1000" data-fresh-interval="700">
                                        
                                            @if ($kinerja > 70)
                                                    <span class="text-success">Baik</span>
                                                @elseif($kinerja < 70 && $kinerja > 50)
                                                    <span style="color: blue">Cukup</span>
                                                @else
                                                    <span class="text-danger">Perlu Perhatian</span>
                                                @endif
                                        </h5>
                                        <small>Kinerja {{round($kinerja)}}%</small>
                                        @endif
                                    
                                    @else
                                    <i class="zmdi zmdi-book zmdi-hc-2x"></i>
                                    <h5 class="m-b-0 number" data-from="0" data-to="1980" data-speed="1000" data-fresh-interval="700">-</h5>
                                    <small>Belum Ada Pekerjaan</small>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-calendar zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" data-from="0" data-to="52" data-speed="1000" data-fresh-interval="700" id="total_hari">-</h5>
                                        <small>Hari Kerja</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-thumb-up zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" id="total_pekerjaan_selesai" data-from="0" data-to="1203" data-speed="1000" data-fresh-interval="700">-</h5>
                                        <small>Pekerjaan Selesai</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">                            
                                        <i class="zmdi zmdi-account zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" id="total_anggota" data-from="0" data-to="52" data-speed="1000" data-fresh-interval="700">-</h5>
                                        <small>Anggota</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-home zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" data-from="0" data-to="1980" data-speed="1000" data-fresh-interval="700" id="total_bidang">-</h5>
                                        <small>Bidang</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-calendar zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" data-from="0" data-to="52" data-speed="1000" data-fresh-interval="700" id="total_hari">-</h5>
                                        <small>Hari Kerja</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-thumb-up zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number" id="total_pekerjaan_selesai" data-from="0" data-to="1203" data-speed="1000" data-fresh-interval="700">-</h5>
                                        <small>Pekerjaan Selesai</small>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <div role="tabpanel" class="tab-panel active" id="schedule">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Mengisi</strong> jurnal</h2>
                                    </div>
                                    
                                    <form id="formaddjob">@csrf
                                        <div class="row">
                                            {{-- <div class="col-xl-6 m-b-20">
                                                <div class="body">
                                                    <p style="text-transform: uppercase">TANGGAL</p>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" name="tanggal" required>
                                                    </div>
                                                    <div style="text-align: right">
                                                        <label style="margin-top: 10px;">
                                                            <input type="checkbox" disabled value="selesai" name="status[]" id="status" style="margin-top: 10px;" >
                                                            <span class="checkmark"></span>
                                                        </label>       
                                                    </div>
                                                </div> 
                                            </div> --}}

                                            <div class="col-xl-12 m-b-20">
                                                <div class="body" style="">
                                                    {{-- <h2 class="card-inside-title">Jenis Pekerjaan ..</h2> --}}
                                                    <div class="form-group">
                                                        <p style="text-transform: uppercase">Jenis Pekerjaan</p>
                                                        <div class="form-line">
                                                            @auth
                                                            @endauth
                                                            <input list="listjenis" type="text" name="jenis[]" class="form-control" placeholder="..." required>
                                                            <datalist id="listjenis">
                                                            @foreach ($jenis as $item)
                                                                <option value="{{$item->jenis}}">{{$item->jenis}}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                    <div style="text-align: right">
                                                        <label style="margin-top: 10px;">
                                                            <input type="checkbox" value="selesai" name="status[]" id="status" style="margin-top: 10px;" >
                                                            <span class="checkmark">Selesai</span>
                                                        </label>       
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 m-b-20">
                                                <div class="body">
                                                    <h2 class="card-inside-title">Deskripsi ..</h2>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="4" name="deskripsi[]" class="form-control no-resize" placeholder="Tulis kendala / proses yang perlu menjadi catatan..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @auth
                                        <input type="submit" class="btn btn-info btn-round waves-effect" id="btnadd" style="margin-bottom: 50px" value="SUBMIT">
                                            @else
                                        <button type="button" data-toggle="modal" data-target="#user" class="btn btn-danger btn-round waves-effect">MASUK UNTUK MENGISI JURNAL</button>
                                        @endauth
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12" id="card_jurnal">
                                <div class="card" id="isi_jurnal">
                                    <div class="header">
                                        <h2><strong>Info</strong></h2>
                                    </div>
                                    @auth
                                        @if ($jobhariini > 0)
                                            @foreach ($joblist as $jlist)
                                            <a href="#" data-toggle="modal" data-target="#modalupdate" data-id="{{$jlist->id}}" data-jenis="{{$jlist->jenis->jenis}}" data-deskripsi="{{$jlist->deskripsi}}" data-tanggal="{{$jlist->start}}" data-status="{{$jlist->status}}">
                                                <div class="card">
                                                    <div class="body m-b-10">
                                                        <div class="event-name b-lightred row">
                                                            <div class="col-3 text-center">
                                                                <h4>{{\Carbon\Carbon::parse($jlist->start)->isoFormat('D')}}<span>{{\Carbon\Carbon::parse($jlist->start)->isoFormat('MMM')}}</span><span>{{\Carbon\Carbon::parse($jlist->start)->isoFormat('Y')}}</span></h4>
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
                                            
                                            @foreach ($joblist as $jlist)
                                                <a href="#" data-toggle="modal" data-target="#modalupdate" data-id="{{$jlist->id}}" data-jenis="{{$jlist->jenis->jenis}}" data-deskripsi="{{$jlist->deskripsi}}" data-tanggal="{{$jlist->start}}" data-status="{{$jlist->status}}">
                                                <div class="card">
                                                    <div class="body m-b-10">
                                                        <div class="event-name b-lightred row">
                                                            <div class="col-3 text-center">
                                                                <h4>{{\Carbon\Carbon::parse($jlist->start)->isoFormat('D')}}<span>{{\Carbon\Carbon::parse($jlist->start)->isoFormat('MMM')}}</span><span>{{\Carbon\Carbon::parse($jlist->start)->isoFormat('Y')}}</span></h4>
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
                                            {{-- {{ $joblist->links() }} --}}
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
                </div>
            </div>
        </div>
        <div class="row">
            
            {{-- <div class="body col-md-12 col-12 m-b-10" style="text-align: right">
                    <a class="btn  btn-sm waves-effect" href="/agenda-jurnal" style="background-color: rgb(186, 134, 255)">
                    {{ __('Kalender') }}
                    </a>

                    <a class="btn  btn-sm waves-effect" href="/jurnal-harian" style="background-color: rgb(255, 134, 150)">
                    {{ __('Mengisi Jurnal ?') }}
                    </a>
                @auth
                    <a class="btn  btn-sm btn-primary waves-effect" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                @endauth
            </div> --}}
            {{-- <div class="header col-md-12 col-12 m-b-10" >
                <h5><strong>Pekerjaan </strong></h5>
            </div> --}}
            
            
            {{-- <div class="col-lg-4 col-md-6" id="card_jurnal_kalender">
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
            </div> --}}
        </div>        
    </div>
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
                                        <table id="table-anggota" class="table table-bordered table-stripped table-hover js-basic-example dataTable">
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
                                                <input type="hidden" name="id" id="id" class="form-control" required>
                                                @auth
                                                    
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
                        {{-- <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal" disabled>HAPUS</button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>

    @auth
        <input type="hidden" id="stat" value="masuk">
        <input type="hidden" id="user_id" value="{{auth()->user()->anggota_id}}">        
    @else
        <input type="hidden" id="stat" value="non">
    @endauth
</section>
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
    $(document).ready(function(){
                            var stat = $('#stat').val();
                            
                            if (stat == 'masuk') {
                                console.log(stat);
                                var user = $('#user_id').val();
                                console.log(user);
                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-bidang',
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_bidang').html(response);
                                    }
                                });
                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-pekerjaan-selesai/'+ user,
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_pekerjaan_selesai').html(response);
                                    }
                                });
                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-hari/'+ user,
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_hari').html(response);
                                    }
                                });
                            }else{
                                $("#user").modal('show');
                                console.log(stat);
                                // total anggota keseluruhan

                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-anggota',
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_anggota').html(response);
                                    }
                                });

                                $("#user").modal('show');
                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-bidang',
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_bidang').html(response);
                                    }
                                });
                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-pekerjaan-selesai',
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_pekerjaan_selesai').html(response);
                                    }
                                });
                                $.ajax({
                                    contentType: false,
                                    processData: false,
                                    url: '/total-hari',
                                    type: "GET",
                                    success: function (response) {
                                        console.log(response);
                                        $('#total_hari').html(response);
                                    }
                                });
                            }
            })
</script>
<script>
    $('#modalupdate').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id')
                    var jenis = button.data('jenis')
                    var deskripsi = button.data('deskripsi')
                    var status = button.data('status')
                    var tanggal = button.data('tanggal')
                    var modal = $(this)
                    $('#id').val(id);
                    $('#jenis').val(jenis);
                    $('#deskripsi').text(deskripsi);
                    $('#status').text(status);
                    $('#tanggal').text(tanggal);
                    console.log(tanggal);
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
        
        $('#table-anggota').DataTable({
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
    
</script>
<script>
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
                    $('#isi_jurnal a').remove();
                    $('.wewewe').remove();
                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                        ];
                    $.ajax({
                        url:"jurnalku-data",
                        type: 'get',
                        dataType: 'json',
                            success:function(datas) {
                                console.log(datas.length);
                                for (let index = 0; index < datas.length; index++) {
                                    var tgl = new Date(datas[index].start);
                                    
                                    card_jurnalku = '<a style="text-black" data-toggle="modal" data-target="#modalupdate" data-id="'+datas[index].id+'" data-jenis="'+datas[index].jenis.jenis+'" data-deskripsi="'+datas[index].deskripsi+'" data-status="'+datas[index].status+'" data-tanggal="'+datas[index].start+'">'
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
                                    // $('#belum_mengisi').remove();                                    
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
                    // $('#isi_jurnal a').remove();
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
                                    card_jurnalku = '<a style="text-black;" data-toggle="modal" data-target="#modalupdate" data-id="'+datas[index].id+'" data-jenis="'+datas[index].jenis.jenis+'" data-deskripsi="'+datas[index].deskripsi+'" data-status="'+datas[index].status+'" data-tanggal="'+datas[index].start+'">'
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
                                    // $('#belum_mengisi').remove();
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