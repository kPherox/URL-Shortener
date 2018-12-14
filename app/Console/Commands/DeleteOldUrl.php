<?php

namespace App\Console\Commands;

use App\ShortUrl;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:delete-old-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the URL after one week or more after creation';

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
        ShortUrl::whereRegistered(false)
            ->whereDate('created_at', '<', Carbon::now()->subWeek(1))
            ->delete();
    }
}
