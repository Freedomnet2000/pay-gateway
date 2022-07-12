<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class SaleManagement
{

    public function addSale() {
        $time = $this->getTime();
        $payme_sale_code = $this->getPaymeSaleCode();
        $description = $this->getDescription();
        $salePrice = $this->getSalePrice();
        $currency = $this->getCurrency();
        $sale_url = $this->getSaleUrl();

        $query ="insert into sales ( time, sale_number, description, sale_price, currency, url) values ( '$time' ,$payme_sale_code ,'$description' ,$salePrice , '$currency','$sale_url')";
        $this->dbResult = DB::insert($query);
        return $this;
    }


    /**
     * @var string
     */
    private $time;

    /**
     * @var string
     */
    private $sale_url;

    /**
     * @var integer
     */
    private $payme_sale_code;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $sale_price;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var bool
     */
    private $dbResult;

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getSaleUrl(): string
    {
        return $this->sale_url;
    }

    /**
     * @param string $sale_url
     */
    public function setSaleUrl(string $sale_url): void
    {
        $this->sale_url = $sale_url;
    }

    /**
     * @return int
     */
    public function getPaymeSaleCode(): int
    {
        return $this->payme_sale_code;
    }

    /**
     * @param int $payme_sale_code
     */
    public function setPaymeSaleCode(int $payme_sale_code): void
    {
        $this->payme_sale_code = $payme_sale_code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSalePrice(): string
    {
        return $this->sale_price;
    }

    /**
     * @param string $sale_price
     */
    public function setSalePrice(string $sale_price): void
    {
        $this->sale_price = $sale_price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return bool
     */
    public function isDbResult(): bool
    {
        return $this->dbResult;
    }

    /**
     * @param bool $dbResult
     */
    public function setDbResult(bool $dbResult): void
    {
        $this->dbResult = $dbResult;
    }
}
