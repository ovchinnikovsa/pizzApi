<?php

namespace App\Controller;

use App\Controller\ApiController;
use App\Interface\OrderController;
use App\Database\DTO\OrdersDto;
use App\Database\Models\Order as OrderModel;

class Order extends ApiController implements OrderController
{
    public static function newOrder(OrdersDto $dto): void
    {
        OrderModel::insert(
            $dto->uuid,
            $dto->getItemsAsString()
        );
    }

    public static function addToOrder(OrdersDto $dto): void
    {
        OrderModel::updateItems(
            $dto->uuid,
            $dto->getItemsAsString()
        );
    }

    public static function getOrder(OrdersDto $dto): void
    {
        OrderModel::getByUuid($dto->uuid);
    }

    public static function setOrderDone(OrdersDto $dto): void
    {
        OrderModel::insert($dto->uuid, $dto->done);
    }

    public static function getAllOrder(OrdersDto $dto): void
    {
        OrderModel::getList($dto->done);
    }
}
