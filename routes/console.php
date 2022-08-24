<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reminderjurnal', function(){
    $x = App\Models\Joblist::select('anggota_id')->whereDate('start', date('Y-m-d'))->distinct()->get();
    $y = App\Models\Anggota::select('*')->whereNotIn('id',$x)->get();

    foreach ($y as $key => $value) {
        # code...
        set_time_limit(0);
        $curl = curl_init();
        $token = "ErPMCdWGNfhhYPrrGsTdTb1vLwUbIt35CQ2KlhffDobwUw8pgYX4TN5rDT4smiIc";
        $payload = [
            "data" => [
                [
                    'phone' => $value->phone,
                    'message' => $value->nama.' - Anda belum mengisi jurnal harian. Dimohon untuk mengisi jurnal kegiatan hari ini pada *https://jurnal.tilawatipusat.com*',
                    'secret' => false, // or true
                    'retry' => false, // or true
                    'isGroup' => false, // or true
                ]
            ]    
        ];
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
                curl_setopt($curl, CURLOPT_URL, "https://solo.wablas.com/api/v2/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                curl_close($curl);
    }
})->purpose('Mengirimkan pesan whatsapp ke anggota yang belum mengisi jurnal');