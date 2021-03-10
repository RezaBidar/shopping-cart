<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('sum_cart_prices', [$this, 'sumCartPrices']),
            new TwigFilter('sum_order_prices', [$this, 'sumOrderPrices']),
        ];
    }

    public function sumCartPrices(array $array)
    {
        return array_reduce($array, function($carry, $item)
        {
            return $carry + ($item->getProduct()->getPrice() * $item->getQuantity());
        });
    }

    public function sumOrderPrices(array $array)
    {
        return array_reduce($array, function($carry, $item)
        {
            return $carry + ($item->getPrice() * $item->getQuantity());
        });
    }
}
