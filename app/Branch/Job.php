<?php

namespace App\Branch;

use App\Models\Branch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $branchId) {}

    public function handle(): void
    {

        Context::put($this->branchId);

        // create tables
        \App\Models\Item::on(Context::connectionName())->fromQuery("CREATE TABLE branches_db." . $this->branchId . "_items LIKE laravel.items"); // @todo

        // copy data
        // ...

        // create triggers for change logs
        // ...

        Branch::query()->whereKey($this->branchId)->update(['status' => 1]);
    }
}
