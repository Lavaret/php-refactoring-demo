<?php


namespace Services;

use Brick\Math\BigDecimal;

class ProductService
{
    public function checkValidPrice(BigDecimal $price)
    {
        if ($price == null || $price->getSign() <= 0) {
            throw new \Exception("Invalid price");
        }
    }

    public function checkNegativeCounter(int $counter) {
        if ($counter < 0) {
            throw new \Exception("Negative counter");
        }
    }

    public function checkNullCounter(int $counter) {
        if ($counter === null) {
            throw new \Exception("null counter");
        }
    }

    public function checkNullPrice(BigDecimal $newPrice) {
        if ($newPrice === null) {
            throw new \Exception("new price null");
        }
    }

    public function checkEmptyDesc(string $desc, string $longDesc) {
        if ($longDesc === null || empty($longDesc) || $desc === null || empty($desc)) {
            return true;
        }

        return false;
    }
}