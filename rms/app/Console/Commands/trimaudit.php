<?php

namespace App\Console\Commands;

use App\Audit;
use Carbon\Carbon;
use Illuminate\Console\Command;

class trimaudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trim:audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trim Audit entries that are older then three months';

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
        //
        Audit::where('created_at','<',Carbon::now()->subMonths(3)->toDateTimeString())->each(function ($entry){
            $entry->delete();
        });
        $this->line('Audit table cleaned till '.Carbon::now()->subMonths(3)->toDateTimeString());
    }
}
