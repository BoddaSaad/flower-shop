<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'cart';

    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function add(int $productId, int $quantity = 1, array $attributes = [
        'gifts' => [],
        'message' => '',
        'receiver_number' => '',
        'delivery_date' => '',
    ]): array
    {
        $cart = $this->getCart();
        $found = false;

        foreach ($cart as &$item) {
            if (
                $item['product_id'] === $productId &&
                $item['attributes'] == $attributes
            ) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id' => count($cart) + 1,
                'product_id' => $productId,
                'quantity' => $quantity,
                'attributes' => $attributes,
            ];
        }

        Session::put($this->sessionKey, $cart);
        return $cart;
    }

    public function update(int $itemId, array $attributes, int $quantity): array
    {
        $cart = $this->getCart();

        foreach ($cart as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] = $quantity;
                $item['attributes']['message'] = $attributes['message'];
                $item['attributes']['delivery_date'] = $attributes['delivery_date'];
                $item['attributes']['receiver_number'] = $attributes['receiver_number'];
                break;
            }
        }

        Session::put($this->sessionKey, $cart);
        return $cart;
    }

    public function remove(int $itemId): array
    {
        $cart = $this->getCart();

        $cart = array_filter($cart, function ($item) use ($itemId) {
            return !($item['id'] === $itemId);
        });

        $cart = array_values($cart);
        Session::put($this->sessionKey, $cart);
        return $cart;
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
