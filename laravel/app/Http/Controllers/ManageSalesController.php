<?php

namespace App\Http\Controllers;

use App\Models\SaleManagementModel;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class ManageSalesController extends BaseController
{

    private string $sale_number;

    public function GetSaleByCode(Request $request)
    {
        $this->sale_number = $request->get('code');
        $getSaleRaw = new SaleManagementModel();
        $getSaleRaw->setPaymeSaleCode($this->sale_number);
        $saleByCode = $getSaleRaw->getSalesDataByCode();
        if  (!$saleByCode->isDbResult()) {
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  "Could not find sale $this->sale_number"
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

    public function updateSaleByCode(Request $request)
    {
        $data = (array) $request->all();
        if (!$this->ValidateVariables($data)) {
            return json_encode(array(
                'code'      =>  401,
                'message'   =>  'Invalid params'
            ), 401);
        }

        $updateSale = new SaleManagementModel();
        $updateSale->setPaymeSaleCode( $data['sale_number']);
        $updateSale->setDescription( $data['description']);
        $updateSale->setSalePrice( $data['amonut']); // TODO - need to fix the typo
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


    public function deleteSaleByCode(Request $request)
    {
        $data = (array)$request->all();
        if (!$this->ValidateVariables($data)) {
            return json_encode(array(
                'code' => 401,
                'message' => 'Invalid params'
            ), 401);
        }

        $updateSale = new SaleManagementModel();
        $updateSale->setPaymeSaleCode($data['sale_number']);
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
