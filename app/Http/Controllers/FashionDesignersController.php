<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Monarobase\CountryList\CountryListFacade;
use App\Models\FashionDesigner;

use function PHPUnit\Framework\isNull;

class FashionDesignersController extends Controller
{
    public function index(){
        $data = FashionDesigner::select('name','country')->get();
        $fashionDesigners = $data->map(function ($designer){
            return [
                'name' => $designer->name,
                // A partir de la libería, con el nombre del país en la BD, se otiene el nombre largo del país
                'country' => CountryListFacade::getOne($designer->country,'es')
            ];
        })->toArray();
        // dd($fashionDesigners);
        // dd($fashionDesigners->toArray());
        return view('fashionDesigners.index')->with('fashionDesigners',$fashionDesigners);
    }

    public function create(){
        // Créditos a https://github.com/Monarobase/country-list
        $countries = CountryListFacade::getList(config('constants.languages.Spanish'));
        return view('fashionDesigners.create')->with('countries',$countries);
    }

    public function store(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'country' => 'required|string',
        ]);
       
        FashionDesigner::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);
        
        return redirect()->to('/dashboard')->with('message', 'El diseñador de moda con nombre '.$request->name. ' ha sido creado');
    }

    public function ajaxViewDatatable(Request $request){
        // La respuesta es de tipo Json
        if (!$request->wantsJson()){
            return redirect('/')->withErrors('Requerimiento inválido.');
        }
        // Se llama a una función definida en la clase Controller para comprobar que las reglas de DT sean válidas
        self::checkDataTablesRules();
        $searchPhrase = $request->search['value'];
        // Si la búsqueda es muy corta, la abortamos.
        if (!empty($searchPhrase)){
            if (preg_match("/^.{1}\$",$searchPhrase)) {
                // Devolvemos un json vacío
                return response()->json(['data' => []]);
            }
        }
        $data = FashionDesigner::select('name','country');

        $numTotal = $numRecords = $data->count(); 

        // Aplicamos filtros de búsqueda
        if (!empty($search['value'])){
            // Búsqueda por nombre o por país
            if (preg_match("/[0-9a-zA-ZÀ-ÿ\u00f1\u00d1]{3,}\$/i",$searchPhrase)) {
                
                $data->where(function($query) use ($searchPhrase){
                    $query->orWhere('name','like','%'.$searchPhrase.'%')
                    ->orWhere('country','like','%'.$searchPhrase.'%');
                });
                // Se actualiza el número de records
                $numRecords = $data->count();    
            }
        }

        // Si la primera fila es nula, devolvemos un Json vacío
        $firstRow = $data->first();
        if (isNull($firstRow)){
            return response()->json(['data' => []]);
        }

        $collectionKeys = array_keys($firstRow->toArray());

        /**
         * Aplicando orden de búsqueda
         */
        $orderList = $request->order;
        foreach($orderList as $orderSetting) {
            $indexCol = $orderSetting['column'];
            $dir = $orderSetting['dir'];

            if(isset($request->columns[$indexCol]['data'])) {
                $colName = $request->columns[$indexCol]['data'];
                if(in_array($colName, $collectionKeys))
                    $data->orderBy($colName, $dir);
                //dd("order by col " . $colName);
            }
        }

        $data = $data->get();
        if ($data->isEmpty()){
            return response()->json(['data' => []]);
        }

        // Procesar datos
        // foreach($data as $row){

        // }
        if ($request->wantsJson()){
            return self::responseDataTables($data->toArray(), (int)$request->draw, $numTotal, $numRecords); 
        }
    }
}
