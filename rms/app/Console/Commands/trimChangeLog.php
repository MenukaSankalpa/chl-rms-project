<?php

namespace App\Console\Commands;

use App\ChangeLog;
use Illuminate\Console\Command;

class trimChangeLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trim:changelog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trims Changelog data older than three months';

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
        ChangeLog::where('created_at','<',Carbon::now()->subMonths(3)->toDateTimeString())->each(function ($entry){
            $entry->delete();
        });
        $this->line("Change log table cleaned till ".Carbon::now()->subMonths(3)->toDateTimeString());

    }
}
