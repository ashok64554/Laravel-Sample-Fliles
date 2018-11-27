<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PgBg;
use App\Websitesetting;
use anlutro\cURL\cURL;

class SmspushpgCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smspushpg:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perfomance Gaurantee Date Approaching data send messsage daily morning';

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
     * @return mixed
     */
    public function handle()
    {
        $from = date('Y-m-d');
        $till = date('Y-m-d', strtotime($from. ' + 60 days'));
        $info = array();
        $pgbgs = PgBg::select('tender_name','maturity_date')
                ->where('maturity_date','>=', $from)
                ->where('maturity_date','<=', $till)
                ->where('pg_status', 'Pending')
                ->join('tenders', function ($join) {
                        $join->on('tenders.id', '=', 'pg_bgs.tender_id');
                    })
                ->orderBy('maturity_date', 'ASC')
                ->get();
        $count = 1;
        foreach($pgbgs as $pgbg)
        {
            $info[]     = '#'.$count.' Tender Name-' .$pgbg->tender_name. ' And Maturity Date-'.$pgbg->maturity_date.' ';
            $count++;
        }
        $allInfo = implode(",",$info);

        /////////////Message
        $getInfo     = Websitesetting::select('mobilenum','website_name','address','smsApiUrl','smsUserName','smsMsgToken','senderId')->first();
        if(strlen($getInfo->mobileNum)==10)
        {
            $mobile = '91'.$getInfo->mobileNum;
        }
        else
        {
            $mobile = $getInfo->mobileNum;
        }

        $sendto         = $mobile;
        $message = 'This message comes from '.$getInfo->website_name.'. To inform you Perfomance Gaurantee Date Approaching. please check '.$allInfo;
        $curl = new cURL;
        $url = $curl->buildUrl($getInfo->smsApiUrl, 
            [
                'username'  => $getInfo->smsUserName, 
                'msg_token' => $getInfo->smsMsgToken, 
                'sender_id' => $getInfo->senderId, 
                'message'   => $message, 
                'mobile'    => $sendto
            ]);
        $response = $curl->get($url);
        $this->info('smspushpg:cron Cummand Run successfully! Info Is - ' .$message );
    }
}
