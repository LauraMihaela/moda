<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Monarobase\CountryList\CountryListFacade;
use App\Models\FashionDesigner;
use Illuminate\Http\JsonResponse;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FashionDesignersController extends Controller
{
    public function index(){
        $data = FashionDesigner::select('id','name','country')->get();
        $fashionDesigners = $data->map(function ($designer){
            return [
                'id' => $designer->id,
                'name' => $designer->name,
                // A partir de la libería, con el nombre del país en la BD, se otiene el nombre largo del país
                'country' => CountryListFacade::getOne($designer->country,'es')
            ];
        })->toArray();
        if(!$fashionDesigners){
            // dd($fashionDesigners);
        }
        // dd($fashionDesigners);
        // dd($fashionDesigners->toArray());
        return view('fashionDesigners.index')->with('fashionDesigners',$fashionDesigners);
    }

    public function create(){
        // Créditos a https://github.com/Monarobase/country-list
        $countries = CountryListFacade::getList(config('constants.languages.Spanish'));
        return view('fashionDesigners.create')->with('countries',$countries);
    }

    public function show(int $id){
        $fashionDesigner = FashionDesigner::find($id);
        // dd($fashionDesigner->country);
        // Créditos a https://github.com/Monarobase/country-list
        $countries = CountryListFacade::getList(config('constants.languages.Spanish'));
        return view('fashionDesigners.show')->with('countries',$countries)
        ->with('fashionDesigner',$fashionDesigner);    
    }

    public function edit(int $id){
        // Créditos a https://github.com/Monarobase/country-list
        $fashionDesigner = FashionDesigner::find($id);
        $fashionDesigner->country = CountryListFacade::getOne($fashionDesigner->country,'es');
        $countries = CountryListFacade::getList(config('constants.languages.Spanish'));
        return view('fashionDesigners.edit')->with('countries',$countries)
        ->with('fashionDesigner',$fashionDesigner);
    }

    public function update(Request $request, int $id){
        $validatedData = $request->validate([
            'name' => 'required|string|max:250|unique:fashion_designers',
            'country' => 'required|string',
        ]);
        $fashionDesigner = FashionDesigner::find($id);
        if(empty($fashionDesigner)){
            return redirect()->back()->withErrors("No se ha encontrado el diseñador de moda");
        }

        $fashionDesigner->name = $request->name;
        $fashionDesigner->country = $request->country;
        $fashionDesigner->save();

        return redirect()->to('/fashionDesigners')->with('message', 'El diseñador de moda con nombre '.$request->name. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $designerToDelete = FashionDesigner::find($id);
        // dd($designerToDelete);
        $designerName = $designerToDelete->name;
        if(empty($designerToDelete)){
            // La función destroy devuelve un json; así se ha definido en la llamada ajax
            // El json tiene un campo estado (1: error o 0:ok) y un campo mensaje (con un texto)
            // return $this->jsonResponse(1, "El diseñador de moda no se ha encontrado");
            return response()->json(['status' => 1, 'message' => "El diseñador de moda no se ha encontrado"]);
        }
        $designerToDelete->delete($id);
        // return $this->jsonResponse(0, "El diseñador de moda ".$designerName. " ha sido eliminado");
        return response()->json(['status' => 0, 'message' => "El disenador de moda ".$designerName. " ha sido eliminado"]);
    }

    public function store(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:250|unique:fashion_designers',
            'country' => 'required|string',
        ]);
       
        FashionDesigner::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);
        
        return redirect()->to('/fashionDesigners')->with('message', 'El diseñador de moda con nombre '.$request->name. ' ha sido creado');
    }

    public function datatable(Request $request)
{
    // $query = DB::table('fashion_designers')
    //     ->select('name', 'country');

    $query = FashionDesigner::select('id','name','country')->get();    

    $totalData = $query->count();

    $start = $request->input('start');
    $length = $request->input('length');

    $query->skip($start)->take($length);
    // $data = $query->get();
    // $data = $query;
    $data = $query->map(function ($designer){
        return [
            'id' => $designer->id,
            'name' => $designer->name,
            // A partir de la libería, con el nombre del país en la BD, se otiene el nombre largo del país
            'country' => CountryListFacade::getOne($designer->country,'es')
        ];
    });

    return response()->json([
        'draw' => $request->input('draw'),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalData,
        'data' => $data
    ]);
    // if ($request->ajax()){
        // dd(datatables()->of(FashionDesigner::all()));
        // return datatables()->of(FashionDesigner::all())->toJson();
    // }
  		//    ->make(true);
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
