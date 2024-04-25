<?php

namespace App\Database\Models;

use App\Database\DB;

class Order
{
    const TABLE = 'orders';

    public static function insert(string $uuid, string $items): int
    {
        return DB::insert(self::TABLE, [
            'uuid' => $uuid,
            'items' => $items,
        ]);
    }

    public static function updateItems(string $uuid, string $items): bool
    {
        return DB::update(
            self::TABLE,
            ['items' => $items],
            'uuid = ' . $uuid,
        );
    }

    public static function updateDone(string $uuid, bool $done): bool
    {
        return DB::update(
            self::TABLE,
            ['done' => $done],
            'uuid = ' . $uuid,
        );
    }


    public static function getByUuid(string $uuid): array
    {
        return DB::fetchOne(
            self::TABLE,
            ['uuid' => $uuid]
        );
    }

    public static function getList(bool|null $done = null): array
    {
        $where = [];
        if ($done !== null) {
            $where = ['done' => $done];
        }
        return DB::fetchAll(
            self::TABLE,
            $where,
        );
    }
}
