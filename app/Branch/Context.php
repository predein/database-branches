<?php

namespace App\Branch;
class Context
{
    private ?int $id = null;

    public function set(?int $id): void
    {
        $this->id = $id;
    }

    public function get(): ?int
    {
        return $this->id;
    }

    public static function put(?int $id): void
    {
        app(self::class)->set($id);
    }

    public static function id(): ?int
    {
        return app(self::class)->get();
    }
}
