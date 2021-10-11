<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HandleIMCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:im';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理IM历史消息';

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
    public function handle(): int
    {
        return 0;
    }
}
