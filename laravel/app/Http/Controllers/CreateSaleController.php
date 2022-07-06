<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Request;

class CreateSaleController extends BaseController
{


    public function getSale(Request $request)
    {
        $saleData = [];
        $saleData['product_name'] = $request->get('prodName');
        $saleData['sale_price'] = $request->get('price');
        $saleData['currency'] = $request->get('currency');

        $iframeUrl=$this->getPaymentUrl($saleData);


        return view('paymentIframe', ['paymentUrl' => $iframeUrl]);

    }


     public function getPaymentUrl($saleData)
         {
             $saleData['seller_payme_id'] = "MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N";
             $saleData['sale_price'] = $saleData['sale_price']*100;
             $saleData['installments'] = "1";
             $saleData['language'] = "en";

            $dataToSend = json_encode($saleData);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://preprod.paymeservice.com/api/generate-sale");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

        return json_decode($response, false)->sale_url;
     }

}
