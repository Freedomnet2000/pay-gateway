<?php

namespace App\Http\Controllers;

use App\Models\SaleManagementModel;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;



class ManageSalesController extends BaseController
{


    /**
     * Update the specified sale.
     *
     * @param  string  $sale_number
     */
    public function GetSaleByCode($sale_number)
    {
        $getSaleRaw = new SaleManagementModel();
        $getSaleRaw->setPaymeSaleCode($sale_number);
        $saleByCode = $getSaleRaw->getSalesDataByCode();
        if  (!$saleByCode->isDbResult()) {
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  "Could not find sale $sale_number"
            ), 200);
        } else {
            return json_decode(json_encode($saleByCode->getSalesInfo()[0]));
        }
    }


    public function GetAllSales()
    {
        $getSales = new SaleManagementModel();
        $sales = $getSales->getAllales();

        if  (!$sales->isDbResult()) {
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  "Could not find sales"
            ), 200);
        } else {
            return json_decode(json_encode($sales->getSalesInfo()));
        }
    }

    /**
     * Update the specified sale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $sale_number
     */

    public function updateSaleByCode(Request $request , string $sale_number)
    {
        $data = (array) $request->all();
        if (!$this->ValidateVariables($data)) {
            return json_encode(array(
                'code'      =>  401,
                'message'   =>  'Invalid params'
            ), 401);
        }

        $updateSale = new SaleManagementModel();
        $updateSale->setPaymeSaleCode($sale_number);
        $updateSale->setDescription( $data['description']);
        $updateSale->setSalePrice( $data['sale_price']); // TODO - need to fix the typo
        $updateSale->setCurrency( $data['currency']);
        $updateSale->setPaymeSaleCode( $data['sale_number']);
        $updateSale->setSaleUrl($data['url']);

        $update = $updateSale->updateSale();
        if (!$update->isDbResult()) {
            return json_encode(array(
                'code'      =>  500,
                'message'   =>  'Could not update the sale - DB Issue'
            ), 401);
        } else {
            $payme_sale_code= $update->getPaymeSaleCode();
            $msg= "Sale $payme_sale_code has been updated successfully";
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  $msg
            ), 200);
        }
    }


    /**
     * Delete the specified sale.
     *
     * @param  string  $sale_number
     */

    public function deleteSaleByCode($sale_number)
    {
        $updateSale = new SaleManagementModel();
        $updateSale->setPaymeSaleCode($sale_number);
        $delete = $updateSale->deleteSale();
        $payme_sale_code = $delete->getPaymeSaleCode();
        if (!$delete->isDbResult()) {
            return json_encode(array(
                'code' => 500,
                'message' => "Could not update the sale - Could not find sale $payme_sale_code"
            ), 401);
        } else {
            $msg = "Sale $payme_sale_code has been deleted successfully";
            return json_encode(array(
                'code' => 200,
                'message' => $msg
            ), 200);
        }
    }
    public function ValidateVariables($data)
    {
        // Needs to check data
        return true;
    }
}
