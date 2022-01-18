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
        $curl = curl_init();
                $token = "dyr07JcBSmVsb1YrVBTB2A5zNKor0BZ9krv2WnQsjWHG1CRhSktdqazkfuOSY9qh";
                $datas = [
                    'phone' => '081329146514',
                    'message' => $value->nama.' - Jangan lupa mengisi jurnal kegiatan harian anda pada . *https://jurnal.tilawatipusat.com*',
                    'secret' => false, // or true
                    'priority' => false, // or true
                ];
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
                curl_setopt($curl, CURLOPT_URL, "https://simo.wablas.com/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                curl_close($curl);
    }
})->purpose('Mengirimkan pesan whatsapp ke anggota yang belum mengisi jurnal');