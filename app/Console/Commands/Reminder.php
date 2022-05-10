<?php

namespace App\Console\Commands;
use App\Models\Joblist;
use App\Models\Anggota;
use Illuminate\Console\Command;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WEEEEEHEHEHEEE';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!");

        // return 0;
        $x = App\Models\Joblist::select('anggota_id')->whereDate('start', date('Y-m-d'))->distinct()->get();
        $y = App\Models\Anggota::select('*')->whereNotIn('id',$x)->get();

        foreach ($y as $key => $value) {
            # code...

            $curl = curl_init();
            $token = "ETDoFxrQu746dzPyu4V2PxH1LxW7GuYdV2fyxGtIoklIaOz3E0ymAvbSZqeamfRa";
            $payload = [
                "data" => [
                    [
                        'phone' => $value->phone,
                        'message' => 'Yth., Sahabat '.$value->nama.' - Jangan lupa mengisi jurnal kegiatan harian anda pada . *https://jurnal.tilawatipusat.com*',
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
    }
}
