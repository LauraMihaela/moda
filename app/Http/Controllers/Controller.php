<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Checks request data validation for data tables server side request
     * @link https://datatables.net/manual/server-side
     */
    protected function checkDataTablesRules() {
        $rules = [
            'draw' => 'required|numeric|min:1',
            'start' => 'required|numeric|min:0',
            'length' => 'required|numeric|min:-1', //-1 means all records, > 1 the pagination records
            'search.value' => 'present|nullable|string',
            'search.regex' => 'present|string|in:true,false',
            'order.*.column' => 'required|numeric|min:0',
            'order.*.dir' => 'required|string|in:asc,desc',
            'columns.*.data' => 'present|nullable|string|required_without:columns.*.data._,columns.*.data.sort',
            //'columns.*.data._' => 'present|nullable|string|required_without:columns.*.data',
            //'columns.*.data.sort' => 'present|nullable|string|required_without:columns.*.data',
            'columns.*.name' => 'present|nullable|string',
            'columns.*.searchable' => 'required|string|in:true,false',
            'columns.*.orderable' => 'required|string|in:true,false',
            'columns.*.search.value' => 'present|nullable|string',
            'columns.*.search.regex' => 'required|string|in:true,false'
        ];
        request()->validate($rules);
    }

    /** Response for Datatables plugin
     * 
     * @param array $data
     * @param int $draw
     * @param int $total
     * @param int $totalFiltered
     * @link https://datatables.net/manual/server-side
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseDataTables(array $data, int $draw, int $total, int $totalFiltered) {
        $dataSend = array();
        $dataSend['draw'] = $draw;
        $dataSend['recordsTotal'] = $total;
        $dataSend['recordsFiltered'] = $totalFiltered;
        $dataSend['data'] = $data;
        return response()->json($dataSend);
    }
}
