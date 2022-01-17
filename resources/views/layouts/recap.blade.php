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
                    <h2>RECAP JURNAL ADM & IT</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="#"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">App</a></li>
                        <li class="breadcrumb-item active">Recap</li>
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
                    
                    <ul class="nav nav-tabs profile_tab">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#overview">Ringkasan</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usersettings">Mengisi Jurnal</a></li> --}}
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="overview">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-thumb-up zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number count-to" data-from="0" data-to="1203" data-speed="1000" data-fresh-interval="700">1203</h5>
                                        <small>Likes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">                            
                                        <i class="zmdi zmdi-comment-text zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number count-to" data-from="0" data-to="324" data-speed="1000" data-fresh-interval="700">324</h5>
                                        <small>Comments</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-eye zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number count-to" data-from="0" data-to="1980" data-speed="1000" data-fresh-interval="700">1980</h5>
                                        <small>Views</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card text-center">
                                    <div class="body">
                                        <i class="zmdi zmdi-attachment zmdi-hc-2x"></i>
                                        <h5 class="m-b-0 number count-to" data-from="0" data-to="52" data-speed="1000" data-fresh-interval="700">52</h5>
                                        <small>Attachment</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Info</strong></h2>
                                    </div>
                                    <div class="">
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Mengisi</strong> jurnal</h2>
                                    </div>
                                    <div class="body m-b-10">
                                        <div class="form-group">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                        </div>
                                        <div class="post-toolbar-b">
                                            <button class="btn btn-primary btn-round">Post</button>
                                        </div>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table data-table table-bordered table-hover js-basic-example dataTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 15%">ID</th>
                                                        {{-- <th>Name</th> --}}
                                                        <th>JOBLIST</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
        
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th style="width: 15%">ID</th>
                                                        {{-- <th>Name</th> --}}
                                                        <th>JOBLIST</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
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

                $('.data-table').DataTable({
                //karena memakai yajra dan template maka di destroy dulu biar ga dobel initialization
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url:'/recap-jurnal',
                },
                columns: [
                    
                    {
                    data:'tanggal',
                    name:'start'
                    },
                    // {
                    // data:'nama',
                    // name:'nama'
                    // },
                    {
                    data:'joblist',
                    name:'joblist'
                    },
                    
                ]
                });
            })
</script>
@endsection