<?php

namespace App\Database\Models;

use App\Database\DB;
use App\Database\DTO\OrdersDto;
use App\Exception\UserException;

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
            " uuid = \"$uuid\" ",
        );
    }

    public static function updateDone(string $uuid, int $done): bool
    {
        return DB::update(
            self::TABLE,
            ['done' => $done],
            " uuid = \"$uuid\" ",
        );
    }


    public static function getByUuid(string $uuid): OrdersDto
    {
        $order = DB::fetchAll(
            self::TABLE,
            " `uuid` = \"$uuid\" ",
        );

        $order = reset($order);
        if (empty($order))
            throw new UserException('Order not found');

        return new OrdersDto(
            $order['uuid'],
            OrdersDto::setItemsFromString($order['items']),
            $order['done'],
        );
    }

    public static function getList(bool|null $done = null): array
    {
        $where = ' 1 = 1';
        if ($done !== null) {
            $where = " done = \"$done\" ";
        }
        return DB::fetchAll(
            self::TABLE,
            $where,
        );
    }
}
