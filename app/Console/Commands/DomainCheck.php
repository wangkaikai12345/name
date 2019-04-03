<?php

namespace App\Console\Commands;

use App\Application;
use App\Jobs\DomainCheckJob;
use Illuminate\Console\Command;

class DomainCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '域名检测';

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
        // 获取有效的应用
        $apps = Application::where('status', 1)->get();

        if ($apps->count()) {
            foreach ($apps as $app) {

                // 获取未检测和正常的域名
                $domains = $app->domains()->where('status',  '<>', 2)->get();

                if ($domains->count()) {
                    foreach($domains as $domain) {
                        // 分发队列处理
                        DomainCheckJob::dispatch($domain);
                    }
                }
            }
        }
    }
}
