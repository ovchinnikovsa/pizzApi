<?php

namespace App\Validator;

use App\Auth\Auth;
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
        $items = $this->checkOrderItems();
        $res = new OrdersDto(
            $this->generateUuid(),
            $items
        );
        return $res;
    }

    public function addToOrder(): OrdersDto
    {
        $uuid = $this->checkUuid();
        $items = $this->checkOrderItems();
        $res = new OrdersDto(
            $uuid,
            $items
        );
        return $res;
    }

    public function getOrder(): OrdersDto
    {
        $uuid = $this->checkUuid();
        $res = new OrdersDto(
            $uuid,
        );
        return $res;
    }

    public function setOrderDone(): OrdersDto
    {
        $auth = new Auth();
        if (!$auth->isAuthenticated()) {
            throw new UserException('Unauthorized');
        }

        $uuid = $this->checkUuid();
        $res = new OrdersDto(
            $uuid,
            done: 1
        );
        return $res;
    }

    public function getAllOrder(): OrdersDto
    {
        $auth = new Auth();
        if (!$auth->isAuthenticated()) {
            throw new UserException('Unauthorized');
        }

        $done = $this->request->getGetData('done');
        $res = new OrdersDto(
            '',
            done: $done
        );
        return $res;
    }

    private function generateUuid(): string
    {
        return uniqid();
    }

    private function checkOrderItems(): array
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
        return $items;
    }

    private function checkUuid(): string
    {
        $uuid = $this->request->getQueryParam();
        if (empty($uuid)) {
            throw new UserException('Invalid uuid');
        }
        return $uuid;
    }

}
