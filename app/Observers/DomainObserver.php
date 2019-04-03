<?php
namespace App\Observers;

use App\Domain;

class DomainObserver {

    public function created(Domain $domain)
    {
        // 域名创建，更新应用域名个数
        $domain->application()->increment('domain_num');
    }

    public function updated(Domain $domain)
    {
        // 如果是无效域名
        if ($domain->status == 2) {

            $domain->valid_at = now();
            $domain->save();

            $domain->application()->increment('valid_num');
        }

    }

}
