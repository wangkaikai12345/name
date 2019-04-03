<?php

namespace App\Jobs;

use App\Domain;
use App\Service\WeChatService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class DomainCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        //
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $service = new WeChatService();
        $intercept = $service->check($this->domain->title);

        Log::info('检测结束 域名'.$this->domain->title.' 状态'.$intercept );
        $this->domain->status = $intercept;
        $this->domain->save();
    }
}
