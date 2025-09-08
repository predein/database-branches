<?php

namespace App\Branch;
class Context
{
    private ?int $id = null;

    public static function put(?int $id): void
    {
        app(self::class)->set($id);
    }

    public static function id(): ?int
    {
        return app(self::class)->get();
    }

    public static function connectionName(): string
    {
        return app(self::class)->getConnectionName();
    }

    public function set(?int $id): void
    {
        $this->id = $id;
    }

    public function get(): ?int
    {
        return $this->id;
    }

    public function getConnectionName(): string {
        return $this->id ? 'branches' : 'mysql';
    }
}
