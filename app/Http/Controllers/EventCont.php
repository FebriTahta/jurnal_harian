<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Jenis;
use App\Models\Joblist;
use App\Models\Anggota;
use App\Models\Bidang;
use App\Models\Isijurnal;
use Illuminate\Http\Request;
use Validator;
use Redirect,Response;
use DataTables;
use Carbon\Carbon;
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
            $data  = Isijurnal::whereDate('start', '>=', $request->start)
                      ->whereDate('end',   '<=', $request->end)
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

    public function new_update(Request $request)
    {
        $cek_jenis      = Jenis::where('jenis', $request->jenis)->first();
        if ($cek_jenis == null) {
            # code...
            $jenis      =   Jenis::updateOrCreate(['id'=> $request->id],[
                'jenis' =>  $request->jenis
            ]);

            if ($request->has('status')) {
                $joblist    =   Joblist::updateOrCreate(['id'=> $request->id],[
                    'anggota_id'    => Auth::id(),
                    'jenis_id'      => $jenis->id,
                    'title'         => "@ jurnal",
                    'deskripsi'     => $request->deskripsi,
                    'status'        => $request->status,
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
                    'title'         => "@ jurnal",
                    'deskripsi'     => $request->deskripsi,
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
                $joblist    =   Joblist::updateOrCreate(['id'=> $request->id],[
                    'anggota_id'    => Auth::id(),
                    'jenis_id'      => $cek_jenis->id,
                    'title'         => "@ jurnal",
                    'deskripsi'     => $request->deskripsi,
                    'status'        => $request->status,
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
                    'title'         => "@ jurnal",
                    'deskripsi'     => $request->deskripsi,
                ]);
                return response()->json([
                    'datas'   => $joblist,
                    'status'  => 200,
                    'message' => 'Jurnal berhasil di tambahkan'
                ]);
            }

        }
    }

    public function new_input(Request $request)
    {
        $sekarang   = date("Y-m-d H:i:s");
        $tgl        = $sekarang;
        $jurnal     = "@ jurnal";
        

        $validator  = Validator::make($request->all(), [            
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
            $isijurnal  =  Isijurnal::whereDate('start', date("Y-m-d"))->first();
            $isijurnal_id = '';
            
            if ($isijurnal == null) {
                # code...
                $jurnals        =   Isijurnal::updateOrCreate(['id'=> $request->id],[
                    'title'     =>  $jurnal,
                    'start'     =>  $tgl,
                    'end'       =>  $tgl
                ]);

                $isijurnal_id = $jurnals->id;
            } else {
                # code...
                $isijurnal_id = $isijurnal->id;
            }

            
            foreach ($request->jenis as $key => $value) {
                $cek_jenis  = Jenis::where('jenis', $value)->first();
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
                            'isijurnal_id'  => $isijurnal_id,
                            'title'         => $jurnal,
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
                            'isijurnal_id'  => $isijurnal_id,
                            'title'         => $jurnal,
                            'deskripsi'     => $request->deskripsi[$key],
                            'status'        => "belum",
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
                            'isijurnal_id'  => $isijurnal_id,
                            'title'         => $jurnal,
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
                            'isijurnal_id'  => $isijurnal_id,
                            'title'         => $jurnal,
                            'deskripsi'     => $request->deskripsi[$key],
                            'status'        => "belum",
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
            $sekarang   = date("Y-m-d");
            if(request()->ajax())
            {
                $datas = Joblist::where('anggota_id', Auth::user()->anggota->id)->with('jenis')->orderBy('id','desc')->
                whereDate('start', $sekarang)->get();
                return response()->json($datas,200);
            }
        }
        
    }

    public function show(Request $request, $start)
    {
        $datas = Anggota::with('bidang')->whereHas('joblist',function ($e) use ($start){
            $e->whereDate('start', $start);
        })->orderBy('id','desc')->get();
        return response()->json($datas,200);
    }

    public function show_my_job(Request $request, $anggota_id, $tanggal)
    {
        $tgl = date("Y-m-d", strtotime($tanggal));
        $joblist1 = Joblist::whereDate('start', '>=', $tgl)
        ->whereDate('end',   '<=', $tgl)->where('anggota_id', $anggota_id)->with('jenis')->get();
        return response()->json($joblist1,200);
    }

    // RECAP DATA
    public function recap(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = Joblist::select('*')
        //             ->with('jenis')
        //             ->with('anggota');
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('tanggal', function($row){
        //                 $btn = Carbon::parse($row->start)->isoFormat('D MMMM Y');
        //                 return $btn;
        //             })
        //             ->rawColumns(['tanggal'])
        //             ->make(true);
        // }

        if ($request->ajax()) {
            $data = Isijurnal::select('*')->with('joblist');
            return  Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function($row){
                        $btn = Carbon::parse($row->start)->isoFormat('D MMMM Y');
                        return $btn;
                    })
                    // ->addColumn('nama', function($row){
                        
                    //     $joblist = Joblist::where('isijurnal_id', $row->id)
                    //             ->select('anggota_id')->distinct()->get();
                    //     foreach ($joblist as $key => $value) {
                    //         # code...
                            
                    //         $x = Anggota::where('id', $value->anggota_id)->first();
                    //         $y[] = $x->nama;

                    //     }
                    //     return implode("<hr>", $y);
                        
                    // })
                    ->addColumn('joblist', function($row){
                        
                        $joblist = Joblist::where('isijurnal_id', $row->id)->with('anggota')
                                ->select('anggota_id')->distinct()->get();
                        foreach ($joblist as $key => $value) {
                            # code...
                            
                            $x = Anggota::where('id', $value->anggota_id)->first();
                            foreach ($x->joblist as $key => $job) {
                                # code...
                                $desk = '';
                                $stat = '';
                                if ($job->deskripsi !== null) {
                                    # code...
                                    $desk = ' ( <span style="color: blue">'.$job->deskripsi.'</span> ) ';
                                }
                                if ($job->status == 'selesai') {
                                    # code...
                                    $stat = ' -> <span class="text-success">'.$job->status.'</span>';
                                }else {
                                    # code...
                                    $stat = ' x <span class="text-danger">'.$job->status.'</span>';
                                }
                                $jobs[] = $job->anggota->nama.' - '.$job->jenis->jenis. $desk. $stat;
                            }
                            $y[] = $x->nama;
                        }
                        $hasil =  implode(" <br> ", $jobs);
                        return ucfirst($hasil);
                        
                    })
                    ->rawColumns(['tanggal','nama','joblist'])
                    ->make(true);
        }
        return view('layouts.recap');
    }

    public function get_username_from_bidang(Request $request, $bidang_id)
    {
        // $username = Anggota::where('bidang_id',$bidang_id)->get();
        // return json_encode($username);

        if ($request->ajax()) {
            $data = Anggota::where('bidang_id', $bidang_id);
            return  Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('check', function($row){
                        $check = '  <div class="radio inlineblock m-r-20">
                                        <input type="radio" name="username" id="'.$row->id.'" class="with-gap" value="'.$row->id.'">
                                        <label for="'.$row->id.'"> ' .$row->nama.'</label>
                                    </div>';
                        // $check = '<input type="checkbox" name="skill" class="check" value="male">';
                        return $check;
                    })
                    ->rawColumns(['check'])
                    ->make(true);
        }
    }

    // total
    public function total_anggota(Request $request)
    {
        if ($request->ajax()) {
            $anggota = Anggota::all()->count();
            return response()->json($anggota,200);
        }
    }

    public function total_bidang(Request $request)
    {
        if ($request->ajax()) {
            $bidang = Bidang::all()->count();
            return response()->json($bidang,200);
        }
    }

    public function total_pekerjaan_selesai(Request $request)
    {
        if ($request->ajax()) {
            $job = Joblist::all()->count();
            return response()->json($job,200);
        }
    }
    


}
