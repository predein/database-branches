<?php

namespace App\Branch;

use App\Models\BranchAutoIncrement;

class AutoIncrement
{
    public static function next(string $table): int
    {
        $row = BranchAutoIncrement::forTable('items');
        $row->increment('auto_increment');
        return $row->auto_increment;
    }
}
