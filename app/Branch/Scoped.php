<?php

namespace App\Branch;

use Illuminate\Database\Eloquent\Model;

trait Scoped
{
    protected ?string $branchTable = null;

    /**
     * Включать ли переключение подключения при наличии branch?
     */
    protected bool $useBranchConnection = true;

    /**
     * Подключения (ключи из config/database.php['connections']).
     */
    protected string $defaultConnection = 'mysql';
    protected string $branchConnection  = 'branches';

    /**
     * Для artisan/CLI по умолчанию отключаем динамику, чтобы миграции/сидеры работали стабильно.
     */
    protected bool $disableInConsole = true;

    public function getTable()
    {
        if (!$this->shouldBranch()) {
            return parent::getTable();
        }

        if (!$this->branchTable) {
            $branchId = Context::id();
            $this->branchTable = ($branchId ? $branchId . '_' : '') . parent::getTable();
        }
        return $this->branchTable;
    }

    public function setTable($table): static
    {
        $branchId = Context::id();
        if ($branchId && str_starts_with($table, $branchId . '_')) {
            $table = substr($table, strlen($branchId . '_'));
        }
        return parent::setTable($table);
    }

    public function getConnectionName()
    {
        if (!$this->useBranchConnection || !$this->shouldBranch()) {
            return $this->defaultConnection ?: parent::getConnectionName();
        }
        // если branch задан — работаем через branch-подключение
        return $this->branchConnection;
    }

    protected function shouldBranch(): bool
    {
        if ($this->disableInConsole && app()->runningInConsole()) {
            return false;
        }
        return (bool) Context::id();
    }

    /** Удобные «шорткаты» */
    public static function forBranch(?int $id): static
    {
        Context::put($id);
        /** @var Model $m */
        $m = new static();
        // Принудительно выставим соединение с учётом текущего контекста
        $m->setConnection($m->getConnectionName());
        return $m;
    }
}
