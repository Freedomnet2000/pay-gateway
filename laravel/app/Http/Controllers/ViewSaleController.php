<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;


use Illuminate\Support\Facades\DB;


class ViewSaleController extends BaseController
{

    public function showSales(Request $request)
    {
        $sale_number = $request->get('code');
        $sales = DB::select('select * from sales where sale_number = ?', [$sale_number]);
        return json_decode(json_encode($sales[0]));
    }

}
