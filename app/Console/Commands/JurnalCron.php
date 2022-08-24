<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JurnalCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jurnal:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    }
}
