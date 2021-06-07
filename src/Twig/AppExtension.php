<?php

namespace App\Twig;

use App\Controller\BaseController;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $setting;

    public function __construct(BaseController $baseController)
    {
        $this->setting = $baseController->getSetting();
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getSetting', [$this, 'getSetting']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function getSetting()
    {
        return $this->setting;
    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
}
