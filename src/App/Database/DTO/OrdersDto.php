<?php

namespace App\Database\DTO;

class OrdersDto
{
    public function __construct(
        public string $uuid,
        private array $items = [],
        public int|null $done = null,
        public int|null $id = null,
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->items = $items;
        $this->getItemsAsArray();
        $this->done = $done;
    }

    public function getItemsAsArray(): array
    {
        return $this->items;
    }

    public function getItemsAsString(): string
    {
        return self::setItemsFromArray($this->items);
    }

    public static function setItemsFromArray(array $items): string
    {
        return implode('|', array_map('strval', $items));
    }

    public static function setItemsFromString(string $items): array
    {
        return array_map('intval', explode('|', $items));
    }
}