<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Anggota;
use App\Models\Bidang;
use App\Models\Jenis;
use App\Models\Joblist;
use Redirect,Response;
use Illuminate\Http\Request;

class IndexCont extends Controller
{
    public function index()
    {
        if(request()->ajax()) 
        {
            $start  = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end    = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
    
            $data   = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
            return Response::json($data);
        }

        $anggota    = Anggota::all();
        $bidang     = Bidang::all();
        $jenis      = Jenis::all();

        return view('layouts.raw',compact('anggota','bidang','jenis'));
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
        $anggota = Anggota::all();
        $bidang  = Bidang::all();
        return view('layouts.absen',compact('anggota','bidang'));
    }

}
