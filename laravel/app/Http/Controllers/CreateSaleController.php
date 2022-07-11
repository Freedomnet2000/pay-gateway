<?php

namespace App\Http\Controllers;

use App\Libraries\PaymentApi;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;


class CreateSaleController extends BaseController
{


    public function addSale(Request $request)
    {

        $paymentApi = new PaymentApi();
        $salePrice = is_numeric($request->get('sale_price'))? $request->get('sale_price')*100 : false;
        $paymentApi-> setSalePrice($salePrice);
        $paymentApi-> setProductName($request->get('description'));
        $paymentApi-> setCurrency( $request->get('currency'));

        $paymentInfo= json_decode($paymentApi->getPaymentData(),true);

        if ($paymentInfo['status_code']!=0) {
            $message = $paymentInfo['status_error_details'];
            return Response ($message);
        }

        $time=now();
        $sale_url= $paymentInfo['sale_url'];
        $payme_sale_code= $paymentInfo['payme_sale_code'];
        $description= $request->get('description');
        $amount=  $request['sale_price'];
        $currency= $request['currency'];


        $lastTableQuery = DB::select('select id from sales order by id desc limit 1') ;

        $lastIdTable= Json_decode(json_encode($lastTableQuery[0]));
        $newId = $lastIdTable? $lastIdTable->id +1: 1;
        DB::insert('insert into sales (id, time, sale_number, description, amonut, currency, url) values (?, ? ,? ,? ,? ,?,?)', [$newId, $time, $payme_sale_code,$description, $amount, $currency, $sale_url]);
        return view('paymentIframe', ['paymentUrl' => $sale_url, 'code' => $payme_sale_code ]);

    }




}
