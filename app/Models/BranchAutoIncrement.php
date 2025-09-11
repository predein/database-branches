<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchAutoIncrement extends Model
{
    protected $table = 'branches_auto_increment';

    protected $fillable = [
        'table_name',
        'auto_increment',
    ];

    protected $casts = [
        'auto_increment' => 'integer',
    ];

    public static function forTable(string $table): self
    {
        return static::query()->firstOrCreate(
            ['table_name' => $table],
            ['auto_increment' => 1]
        );
    }
}
