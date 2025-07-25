<?php

namespace App\Console\Commands;

use App\Upload;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class trimUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trim:uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove upload files and entries older than one day';

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
        Upload::where('created_at', '<', Carbon::now()->subDays(2)->toDateTimeString())->each(function ($entry) {
            Storage::disk('uploads')->delete($entry->saved_index);
            $entry->delete();
        });
        $this->line('uploads deleted till' . Carbon::now()->subDays(2)->toDateTimeString());

    }
}
