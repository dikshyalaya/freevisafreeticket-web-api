<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class ExpireJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Job if today date is greater than job deadline';

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
        $jobs = Job::where('is_active', 1)->get();
        foreach($jobs as $job){
            $deadline = $job->expiry_date;
            $current_date_time = date('Y-m-d H:i:s');

            if(strtotime($current_date_time) >= strtotime($deadline)){
                $job->update([
                    'is_expired' => 1,
                    'status' => 'Expired',
                ]);
            }
        }
    }
}
