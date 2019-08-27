<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class SshTunnelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssh:tunnel {server : SSH Host in your SSH Configuration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a remote tunnel into the provided server';

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
        $serverAlias = $this->argument('server');
        $redisHost = env('REDIS_HOST', '127.0.0.1');
        $redisPort = env('REDIS_PORT', 6380);

        $serverRedisHost = env('REMOTE_REDIS_HOST', '127.0.0.1');
        $serverRedisPort = env('REMOTE_REDIS_PORT', 6379);

        $command = "ssh -nNT -L {$redisHost}:{$redisPort}:{$serverRedisHost}:{$serverRedisPort} {$serverAlias}";

        $process = new Process($command);
        $process->setTimeout(null);
        $process->run();
    }
}
