<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Jenis;
use App\Models\Joblist;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Validator;
use Redirect,Response;
use Auth;

class EventCont extends Controller
{
    public function create(Request $request)
    {
        $insertArr = [ 'title' => $request->title,
                       'start' => $request->start,
                       'end' => $request->end
                    ];
        $event = Event::insert($insertArr);   
        return Response::json($event);
    }

    public function update(Request $request)
    {
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    }

    public function delete(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
    }

    // new
    public function index(Request $request)
    {
  
        if($request->ajax()) {
       
            // $data = Event::whereDate('start', '>=', $request->start)
            //              ->whereDate('end',   '<=', $request->end)->select('id','title','start','end')
            //              ->get();

            $data = Joblist::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)->select('id','jenis_id','anggota_id','title','start','end')
                    //    ->groupBy('title')
                       ->get();
  
            return response()->json($data);
        }
  
        return view('fullcalender');
    }

    public function ajax(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
              $event = Event::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'update':
              $event = Event::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Event::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }

    public function new_input(Request $request)
    {
        $sekarang = date("d/m/Y");
        $tgl = $request->tanggal;

        $validator = Validator::make($request->all(), [            
            'jenis'         => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status'    => 400,
                'message'   => 'Ada Kesalahan',
                'errors'    => $validator->messages(),
            ]);
        }
        else {
            foreach ($request->jenis as $key => $value) {
                $cek_jenis  = Jenis::where('jenis', $value)->first();
                $anggota    = Anggota::where('id', Auth::user()->anggota_id)->first();
                $nama       = $anggota->nama;
                if ($cek_jenis == null) {
                    # code jika belum ada jenis pekerjaan serupa...
                    $jenis      =   Jenis::updateOrCreate(['id'=> $request->id],[
                        'jenis' =>  $value
                    ]);
    
                    if ($request->has('status')) {
                        # code...
                        $joblist    =   Joblist::updateOrCreate(['id'=> $request->id],[
                            'anggota_id'    => Auth::id(),
                            'jenis_id'      => $jenis->id,
                            'title'         => $nama,
                            'deskripsi'     => $request->deskripsi[$key],
                            'status'        => $request->status[$key],
                            'start'         => $tgl,
                            'end'           => $tgl,
                            // 'tanggal'       => $request->tanggal[$key],
                        ]);
                        return response()->json([
                            'datas'   => $joblist,
                            'status'  => 200,
                            'message' => 'Jurnal berhasil di tambahkan'
                        ]);
                    }else {
                        # code...
                        $joblist    =   Joblist::updateOrCreate(['id'=> $request->id],[
                            'anggota_id'    => Auth::id(),
                            'jenis_id'      => $jenis->id,
                            'title'         => $nama,
                            'deskripsi'     => $request->deskripsi[$key],
                            // 'status'        => $request->status[$key],
                            'start'         => $tgl,
                            'end'           => $tgl,
                            // 'tanggal'       => $request->tanggal[$key],
                        ]);
                        return response()->json([
                            'datas'   => $joblist,
                            'status'  => 200,
                            'message' => 'Jurnal berhasil di tambahkan'
                        ]);
                    }  
                }else {
                    # code...
                    if ($request->has('status')) {
                        # code...
                        $joblist    =   Joblist::updateOrCreate(['id'=> $request->id],[
                            'anggota_id'    => Auth::id(),
                            'jenis_id'      => $cek_jenis->id,
                            'title'         => $nama,
                            'deskripsi'     => $request->deskripsi[$key],
                            'status'        => $request->status[$key],
                            'start'         => $tgl,
                            'end'           => $tgl,
                            // 'tanggal'       => $request->tanggal[$key],
                        ]);
                        return response()->json([
                            'datas'   => $joblist,
                            'status'  => 200,
                            'message' => 'Jurnal berhasil di tambahkan'
                        ]);
                    }else {
                        # code...
                        $joblist    =   Joblist::updateOrCreate(['id'=> $request->id],[
                            'anggota_id'    => Auth::id(),
                            'jenis_id'      => $cek_jenis->id,
                            'title'         => $nama,
                            'deskripsi'     => $request->deskripsi[$key],
                            // 'status'        => $request->status[$key],
                            'start'         => $tgl,
                            'end'           => $tgl,
                            // 'tanggal'       => $request->tanggal[$key],
                        ]);
                        return response()->json([
                            'datas'   => $joblist,
                            'status'  => 200,
                            'message' => 'Jurnal berhasil di tambahkan'
                        ]);
                    }
                }
            }
        }
    }

    public function jurnalku(Request $request)
    {
        if (Auth::user()) {
            # code...
            if(request()->ajax())
            {
                $datas = Joblist::where('anggota_id', Auth::user()->anggota->id)->with('jenis')->orderBy('id','desc')->
                where('start',date('d/m/Y'))->get();
                return response()->json($datas,200);
            }
        }
        
    }
}
