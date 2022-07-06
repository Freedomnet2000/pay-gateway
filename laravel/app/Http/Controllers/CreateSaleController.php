<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;


class CreateSaleController extends BaseController
{


    public function getSale(Request $request)
    {
        $saleData = [];
        $saleData['product_name'] = $request->get('prodName');
        $saleData['sale_price'] = $request->get('price');
        $saleData['currency'] = $request->get('currency');

        $paymentInfo=json_decode($this->getPaymentUrl($saleData),true);

        if ($paymentInfo['status_code']!=0) {
            $message = $paymentInfo['status_error_details'];
            return Response ($message);
        }

        $time=now();
        $sale_url= $paymentInfo['sale_url'];
        $payme_sale_code= $paymentInfo['payme_sale_code'];
        $description= $saleData['product_name'];
        $amount=  $saleData['sale_price'];
        $currency= $saleData['currency'];


        $lastTableQuery = DB::select('select id from sales order by id desc limit 1') ;
//
        $lastIdTable= Json_decode(json_encode($lastTableQuery[0]));
        $newId = $lastIdTable? $lastIdTable->id +1: 1;
        DB::insert('insert into sales (id, time, sale_number, description, amonut, currency, url) values (?, ? ,? ,? ,? ,?,?)', [$newId, $time, $payme_sale_code,$description, $amount, $currency, $sale_url]);
        return view('paymentIframe', ['paymentUrl' => $sale_url, 'code' => $payme_sale_code ]);

    }


     public function getPaymentUrl($saleData)
         {
             $saleData['seller_payme_id'] = "MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N";
             $saleData['sale_price'] = is_numeric($saleData['sale_price'])? $saleData['sale_price']*100 : false;
             $saleData['installments'] = "1";
             $saleData['language'] = "en";

            $dataToSend = json_encode($saleData);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://preprod.paymeservice.com/api/generate-sale");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

         return ($response);
     }

}
