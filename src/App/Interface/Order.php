<?php

namespace App\Interface;

use App\Database\DTO\OrdersDto;

interface Order
{
    public function newOrder(): OrdersDto;

    public function addToOrder(): OrdersDto;

    public function getOrder(): OrdersDto;

    public function setOrderDone(): OrdersDto;

    public function getAllOrder(): OrdersDto;
}
