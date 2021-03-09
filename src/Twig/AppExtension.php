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
            new TwigFilter('sum_prices', [$this, 'sumPrices']),
        ];
    }

    public function sumPrices(array $array)
    {
        return array_reduce($array, function($carry, $item)
        {
            return $carry + ($item->getProduct()->getPrice() * $item->getQuantity());
        });
    }
}
