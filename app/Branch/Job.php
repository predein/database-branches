<?php

namespace App\Branch;

use App\Models\Branch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $branchId) {}

    public function handle(): void
    {
        Context::put($this->branchId);

        // detect all Models with trait \App\Branch\Scoped
        $tables = [
            'items',
        ];

        foreach ($tables as $table) {
            $branch_table = 'branches_db.' . $this->branchId . '_' . $table;
            $original_table = 'laravel.' . $table;
            DB::statement("CREATE TABLE ? LIKE ?", [$branch_table, $original_table]);
        }

        DB::transaction(function () use ($tables) {
            foreach ($tables as $table) {
                $branch_table = 'branches_db.' . $this->branchId . '_' . $table;
                $original_table = 'laravel.' . $table;
                DB::statement("SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO'");
                DB::statement("INSERT INTO ? SELECT * FROM ?", [$branch_table, $original_table]);

                // create triggers for change logs
                // ...
            }
        });

        Branch::query()->whereKey($this->branchId)->update(['status' => 1]);
    }
}
