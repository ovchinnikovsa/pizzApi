<?php

namespace App\Interface;


interface Order
{
    public static function newOrder(): void;

    public static function addToOrder(int $id): void;

    public static function getOrder(int $id): void;

    public static function setOrderDone(int $id): void;

    public static function getAllOrder(int|null $done = null): void;
}
