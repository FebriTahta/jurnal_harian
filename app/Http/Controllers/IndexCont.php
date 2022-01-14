<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Anggota;
use App\Models\Bidang;
use App\Models\Jenis;
use App\Models\Joblist;
use App\Models\Isijurnal;
use Redirect,Response;
use Carbon;
use Auth;
use Illuminate\Http\Request;

class IndexCont extends Controller
{
    public function index()
    {
        if(request()->ajax()) 
        {
            $start  = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end    = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
    
            // $data   = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
            $data   = Joblist::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get();
            return Response::json($data);
        }

        $anggota = Anggota::whereHas('joblist',function ($e){
            $e->whereDate('start', date("Y-m-d"));
        })->orderBy('id','desc')->get();
        $semuaanggota   = Anggota::all();
        $bidang     = Bidang::all();
        $jenis      = Jenis::all();
        $joblist    = Joblist::whereDate('start',date("Y-m-d"))->get();
        $isijurnal  =  Isijurnal::whereDate('start', date("Y-m-d"))->first();

        return view('layouts.raw',compact('anggota','semuaanggota','bidang','jenis','joblist','isijurnal'));
    }

    public function fetch(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = Anggota::where('nama', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {
            $output .= '
            <li><a href="#">'.$row->nama.'</a></li>
            ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function jurnal_harian()
    {
        $sekarang = date("Y-m-d");
        if (Auth::user()) {
            # code...
            $anggota    = Anggota::all();
            $bidang     = Bidang::all();
            $joblist    = Joblist::where('anggota_id', Auth::user()->anggota->id)->orderBy('id','desc')
                                 ->whereDate('start', $sekarang )->get();
            $jenis      = Jenis::all();
            return view('layouts.absen',compact('anggota','bidang','joblist','jenis'));
        }else{
            $anggota    = Anggota::all();
            $bidang     = Bidang::all();
            $jenis      = Jenis::all();
            return view('layouts.absen',compact('anggota','bidang','jenis'));
        }
            
    }

}
