<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class reminderjurnal extends Command
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
    protected $description = 'Mengirimkan pesan whatsapp ke anggota yang belum mengisi jurnal';

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
        // return 0;
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
    }
}
