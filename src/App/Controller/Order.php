<?php

namespace App\Controller;

use App\Controller\ApiController;
use App\Interface\Order as OrderInterface;

class Order extends ApiController implements OrderInterface
{
    public static function newOrder(): void
    {
        return self::send(['new order']);
    }

    public static function addToOrder(int $id): void
    {
        return self::send(['add to order' => $id]);
    }

    public static function getOrder(int $id): void
    {
        return self::send(['add to order' => $id]);
    }

    public static function setOrderDone(int $id): void
    {
        return self::send(['set order done']);
    }

    public static function getAllOrder(int|null $done = null): void
    {
        return self::send(['get all order']);
    }
}
