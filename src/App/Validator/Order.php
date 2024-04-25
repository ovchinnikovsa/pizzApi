<?php

namespace App\Validator;

use App\Validator\Validator;
use App\Interface\Order as OrderInterface;
use App\Database\DTO\OrdersDto;
use App\Exception\UserException;

class Order extends Validator implements OrderInterface
{
    public function validateMethod(string $method)
    {
        return self::$method();
    }

    public function newOrder(): OrdersDto
    {
        $items = $this->request->getPostData('items');
        if (!is_array($items) || empty($items)) {
            throw new UserException('Invalid items, must be an array');
        }
        foreach ($items as $item) {
            if ($item < 1 || $item > 5000) {
                throw new UserException('Invalid item value must be between 1 and 5000');
            }
        }
        $res = new OrdersDto(
            $this->generateUuid(),
            $items
        );
        return $res;
    }

    public function addToOrder(): OrdersDto
    {
    }

    public function getOrder(): OrdersDto
    {
    }

    public function setOrderDone(): OrdersDto
    {
    }

    public function getAllOrder(): OrdersDto
    {
    }

    private function generateUuid(): string
    {
        return uniqid();
    }
}
