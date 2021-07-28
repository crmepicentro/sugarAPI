<?php

namespace App\Console\Commands;

use App\Models\SugarUsersBlocked;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class activeBlockedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active:BlockedUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Active blocked users in Sugar';

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

        SugarUsersBlocked::where('date_unblocked', '<=', date('Y-m-d'))->where('status', 'inactive')->update(['status' => 'active']);
    }
}
