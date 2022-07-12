<?php

namespace App\Http\Controllers;

use App\Models\SaleManagement;
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
        $getSaleRaw = new SaleManagement();
        $getSaleRaw->setPaymeSaleCode($this->sale_number);
        $saleByCode = $getSaleRaw->getSalesDataByCode();
        if  (!$saleByCode->isDbResult()) {
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  "Could not find sale $this->sale_number"
            ), 200);
        } else {
            return json_decode(json_encode($saleByCode[0]));
        }
    }


    public function GetAllSales()
    {
        $getSales = new SaleManagement();
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


        $sale_number = $data['sale_number'];
        $description = $data['description'];
        $amonut = $data['amonut'];  // TODO - need to fix the typo
        $currency = $data['currency'];
        $url = $data['url'];

        $sql = "update sales set  description = '$description', amonut = $amonut, currency= '$currency' , url= '$url' where sale_number = $sale_number";

        $update = DB::update($sql);
        if (!$update) {
            return json_encode(array(
                'code'      =>  500,
                'message'   =>  'Could not update the sale - DB Issue'
            ), 401);
        } else {
            $msg= "Sale $sale_number has been updated successfully";
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  $msg
            ), 200);
        }
    }

    public function ValidateVariables($data)
    {
       // Needs to check data
        return true;
    }

    public function deleteSaleByCode(Request $request)
    {
        $sale_number = $request->get('code');
        $delete = DB::delete('delete from sales where sale_number = ?', [$sale_number]);
        if (!$delete) {
            return json_encode(array(
                'code'      =>  500,
                'message'   =>  'Could not delete the sale - DB Issue'
            ), 500);
        } else {
            $msg= "Sale $sale_number has been deleted successfully";
            return json_encode(array(
                'code'      =>  200,
                'message'   =>  $msg
            ), 200);
        }
    }
}
