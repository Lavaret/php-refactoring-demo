<?php

namespace Refactoring\Products;

use Brick\Math\BigDecimal;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Services\ProductService;

class Product
{
    /**
     * @var UuidInterface
     */
    private $serialNumber;

    /**
     * @var BigDecimal
     */
    private $price;

    /**
     * @var string
     */
    private $desc;

    /**
     * @var string
     */
    private $longDesc;

    /**
     * @var int
     */
    private $counter;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * Product constructor.
     * @param BigDecimal|null $price
     * @param string|null $desc
     * @param string|null $longDesc
     * @param int|null $counter
     */
    public function __construct(?BigDecimal $price, ?string $desc, ?string $longDesc, ?int $counter, ProductService $productService)
    {
        $this->serialNumber = Uuid::uuid4();
        $this->price = $price;
        $this->desc = $desc;
        $this->longDesc = $longDesc;
        $this->counter = $counter;

        $this->productService = $productService;
    }

    /**
     * @return UuidInterface
     */
    public function getSerialNumber(): UuidInterface
    {
        return $this->serialNumber;
    }

    /**
     * @return BigDecimal
     */
    public function getPrice(): BigDecimal
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getLongDesc(): string
    {
        return $this->longDesc;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * @throws \Exception
     */
    public function decrementCounter(): void
    {

        try {
            $this->productService->checkValidPrice($this->price);
            $this->productService->checkNullCounter($this->counter);

            $this->counter--;

            $this->productService->checkNegativeCounter($this->counter);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            //log
        }

    }

    /**
     * @throws \Exception
     */
    public function incrementCounter(): void
    {
        try {
            $this->productService->checkValidPrice($this->price);
            $this->productService->checkNullCounter($this->counter);

            $this->counter++;

            $this->productService->checkNegativeCounter($this->counter);

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
            //log
        }
    }

    /**
     * @param BigDecimal|null $newPrice
     * @throws \Exception
     */
    public function changePriceTo(?BigDecimal $newPrice): void
    {
        try {
            $this->productService->checkNullCounter($this->counter);

            if ($this->counter > 0) {

                $this->productService->checkNullPrice($newPrice);

                $this->price = $newPrice;
            }

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
            //log
        }
    }

    /**
     * @param string|null $charToReplace
     * @param string|null $replaceWith
     * @throws \Exception
     */
    public function replaceCharFromDesc(?string $charToReplace, ?string $replaceWith): void
    {
        if ($this->productService->checkEmptyDesc($this->desc, $this->longDesc)) {
            throw new \Exception("null or empty desc");
        }

        $this->longDesc = str_replace($charToReplace, $replaceWith, $this->longDesc);
        $this->desc = str_replace($charToReplace, $replaceWith, $this->desc);
    }

    /**
     * @return string
     */
    public function formatDesc(): string {
        if ($this->productService->checkEmptyDesc($this->desc, $this->longDesc)) {
            return "";
        }

        return $this->desc . " *** " . $this->longDesc;
    }
}





















