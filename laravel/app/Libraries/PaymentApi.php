<?php

namespace App\Libraries;


use Illuminate\Support\Facades\Config;

class PaymentApi
{
    /**
     * @var string;
     */
    private string $product_name;

    /**
     * @var string;
     */
    private string $sale_price;

    /**
     * @var string;
     */
    private string $currency;

    public function getPaymentData()
    {
        $saleData['seller_payme_id'] = Config::get('constants.seller_payme_id');
        $saleData['sale_price'] = $this->getSalePrice();
        $saleData['product_name'] = $this->getProductName();
        $saleData['currency'] = $this->getCurrency();
        $saleData['installments'] = "1";
        $saleData['language'] = "en";

        $dataToSend = json_encode($saleData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://preprod.paymeservice.com/api/generate-sale");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return (curl_exec($ch));
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->product_name;
    }

    /**
     * @param string $product_name
     */
    public function setProductName(string $product_name): void
    {
        $this->product_name = $product_name;
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

}
