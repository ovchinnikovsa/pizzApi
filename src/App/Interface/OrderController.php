<?php

namespace App\Interface;

use App\Database\DTO\OrdersDto;

interface OrderController
{
    public static function newOrder(OrdersDto $dto): void;

    public static function addToOrder(OrdersDto $dto): void;

    public static function getOrder(OrdersDto $dto): void;

    public static function setOrderDone(OrdersDto $dto): void;

    public static function getAllOrder(OrdersDto $dto): void;
}
