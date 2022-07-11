<?php

namespace tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\CreateSaleController;



class CreateSaleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_that_payment_API_returns_Url()
    {
        $fakeDataArry = [];
        $fakeDataArry['product_name'] = 'Shirt';
        $fakeDataArry['sale_price'] = '20';
        $fakeDataArry['currency'] = 'USD';
        $saleCreate = new CreateSaleController();
        $response= json_decode($saleCreate->getPaymentUrl($fakeDataArry),true);
        $this->assertArrayHasKey('sale_url', $response);

    }

    /** @Test */
    public function test_that_payment_API_returns_Url_with_invalid_currency()
    {
        $fakeDataArry = [];
        $fakeDataArry['product_name'] = 'Shirt';
        $fakeDataArry['sale_price'] = '20';
        $fakeDataArry['currency'] = 'USDD';
        $saleCreate = new CreateSaleController();
        $response= json_decode($saleCreate->getPaymentUrl($fakeDataArry),true);
        $this->assertArrayNotHasKey('sale_url', $response);

    }

}
