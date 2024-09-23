<?php

namespace App\Console\Commands;

use App\Models\HistoryImageAI;
use App\Models\User;
use Illuminate\Console\Command;

class DeleteImageAI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:imageAI';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete images AI if they are older than 10 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        info("Delete images running at ". now());
        $historyImage = HistoryImageAI::all();
        foreach ($historyImage as $h)
        {
            if($h->created_at < now()->subDays(10))
            {
                $h->delete();
            }
        }
    }
}
