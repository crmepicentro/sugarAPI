<?php

namespace App\Console\Commands;

use App\Models\SugarUsersBlocked;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class couponsTSN extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send coupons TSN';

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
        $user_auth = Auth::user();

        if(!$user_auth){
            $user = Auth::loginUsingId(1);
            if($user->fuente !== 'tests_source'){
                $user->connection = 'prod';
            }
        }
        $this->info('aki');
    }
}
