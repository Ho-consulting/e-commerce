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
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('pluralize', [$this, 'doSomething']), 
            new TwigFunction('valueBoolean', [$this, 'AffichageBoolean']),
            new TwigFunction('StatusPlat', [$this, 'statusPlats']),
        ];
    }

    public function doSomething(int $count, string $singular, string $plural):string
    {
        $str = $count === 1 ? $singular : $plural;
        return "$count $str";
    }

    public function AffichageBoolean(int $value, string $true, string $false):string
    {
        $str = $value === 0 ? $false : $true;
        return "$str";
    }
    
    public function statusPlats(int $value, string $true, string $false):string
    {
        $str = $value === 0 ? $false : $true;
        return "$str";
    }
}
