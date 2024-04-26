<?php

namespace App\Controller;

use App\Controller\ApiController;
use App\Exception\UserException;
use App\Interface\OrderController;
use App\Database\DTO\OrdersDto;
use App\Database\Models\Order as OrderModel;

class Order extends ApiController implements OrderController
{
    public static function newOrder(OrdersDto $dto): void
    {
        $id = OrderModel::insert(
            $dto->uuid,
            $dto->getItemsAsString()
        );

        if (!$id)
            throw new UserException('Failed to create new order');

        self::send([
            'order_id' => $dto->uuid,
            'items' => $dto->getItemsAsArray(),
            'done' => $dto->done
        ]);
    }

    public static function addToOrder(OrdersDto $dto): void
    {
        $item_old = $dto->getItemsAsArray();
        $dto = OrderModel::getByUuid($dto->uuid);
        if (!$dto)
            throw new UserException('Order not found');

        if ($dto->done === 1)
            throw new UserException('Order is done');

        $new_items = array_unique(array_merge($item_old, $dto->getItemsAsArray()));
        sort($new_items);

        $update = OrderModel::updateItems(
            $dto->uuid,
            OrdersDto::setItemsFromArray($new_items),
        );
        if (!$update)
            throw new UserException('Failed to update order');

        $dto = OrderModel::getByUuid($dto->uuid);

        self::send([
            'order_id' => $dto->uuid,
            'items' => $dto->getItemsAsArray(),
            'done' => $dto->done
        ]);
    }

    public static function getOrder(OrdersDto $dto): void
    {
        $dto = OrderModel::getByUuid($dto->uuid);
        if (!$dto)
            throw new UserException('Order not found');

        self::send([
            'order_id' => $dto->uuid,
            'items' => $dto->getItemsAsArray(),
            'done' => $dto->done
        ]);
    }

    public static function setOrderDone(OrdersDto $dto): void
    {
        $update = OrderModel::updateDone(
            $dto->uuid,
            $dto->done,
        );
        if (!$update)
            throw new UserException('Failed to update order');

        $dto = OrderModel::getByUuid($dto->uuid);

        self::send([
            'order_id' => $dto->uuid,
            'items' => $dto->getItemsAsArray(),
            'done' => $dto->done
        ]);
    }

    public static function getAllOrder(OrdersDto $dto): void
    {
        $res= OrderModel::getList($dto->done);

        self::send($res);
    }
}
