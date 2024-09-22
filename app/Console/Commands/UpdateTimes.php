<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update times for users who has times less than 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        info("Update times running at ". now());
        $user = User::all();
        foreach ($user as $u)
        {
            if($u->times == 0)
            {
                $u->times += 10;
                $u->save();
            }
        }
    }
}
