<?php

namespace App\Http\Controllers;

use App\Libraries\PaymentApi;
use App\Models\SaleManagementModel;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\Controller as BaseController;


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
        $payme_sale_code = $paymentInfo['payme_sale_code'];
        $addSaleRaw = new SaleManagementModel();
        $addSaleRaw->setTime(now());
        $addSaleRaw->setSaleUrl($paymentInfo['sale_url']);
        $addSaleRaw->setPaymeSaleCode($payme_sale_code);
        $addSaleRaw->setDescription($request->get('description'));
        $addSaleRaw->setSalePrice($salePrice);
        $addSaleRaw->setCurrency($request->get('currency'));

        $manageSale = $addSaleRaw ->addSale();
        if (!$manageSale->isDbResult()) {
            $message = "Unable to save Sale number $payme_sale_code";
            return Response ($message);
        }
        return view('paymentIframe', ['paymentUrl' => $manageSale->getSaleUrl(), 'code' => $manageSale->getPaymeSaleCode() ]);

    }

}
