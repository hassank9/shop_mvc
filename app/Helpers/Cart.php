<?php
declare(strict_types=1);

namespace App\Helpers;

final class Cart
{
    private const KEY = 'cart_items'; // [productId => qty]

    public static function items(): array
    {
        Session::start();
        $items = Session::get(self::KEY, []);
        return is_array($items) ? $items : [];
    }

    public static function count(): int
    {
        $c = 0;
        foreach (self::items() as $qty) $c += (int)$qty;
        return $c;
    }

    public static function add(int $productId, int $qty = 1): void
    {
        Session::start();
        $qty = max(1, min(99, $qty));

        $items = self::items();
        $items[$productId] = (int)($items[$productId] ?? 0) + $qty;
        if ($items[$productId] > 99) $items[$productId] = 99;

        Session::set(self::KEY, $items);
    }

    public static function setQty(int $productId, int $qty): void
    {
        Session::start();
        $qty = max(0, min(99, $qty));

        $items = self::items();
        if ($qty === 0) unset($items[$productId]);
        else $items[$productId] = $qty;

        Session::set(self::KEY, $items);
    }

    public static function clear(): void
    {
        Session::start();
        Session::set(self::KEY, []);
    }
}