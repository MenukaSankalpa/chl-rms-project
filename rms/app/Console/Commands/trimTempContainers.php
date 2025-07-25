<?php

namespace App\Console\Commands;

use App\TempContainer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class trimTempContainers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trim:tempcontainers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Temp container entries that are older than one day';

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
        TempContainer::where('created_at','<',Carbon::now()->subDays(2)->toDateTimeString())->each(function ($entry){
            $entry->delete();
        });
        $this->line('temp_containers deleted till '.Carbon::now()->subDays(2)->toDateTimeString());

    }
}
