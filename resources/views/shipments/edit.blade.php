@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-shipment-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de envíos</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Id del envío {{$shipment->id}}</h4>

                <form action="{{route('shipments.update',$shipment->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-circle-user"></i> </span>
                        </div>
                        <label>Nombre de usuario:</label>
                        <select id="client_id" name="client_id" data-live-search="true" 
                        data-actions-box="true" data-header="Seleccione un nombre de usuario" 
                        title="{{$shipmentUser->username}}" class="form-control mb-1 selectpicker" 
                        selected="{{$shipmentUser->username}}" >
                            <option selected="selected" value="{{$shipmentUser->client_id}}">{{$shipmentUser->username}}</option>
                            @foreach ($allClients as $key => $client)
                                <option value="{{ $client->client_id }}">{{ $client->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-bag-shopping"></i> </span>
                        </div>
                        <label>Producto comprado:</label>
                        <select id="sizes_colors_products_id" name="sizes_colors_products_id" data-live-search="true" 
                        data-actions-box="true" data-header="Seleccione un producto" 
                        title="{{$selectedSizesColorsProducts->product_name}} (Color: {{$selectedSizesColorsProducts->color_name}}) (Tamaño: {{$selectedSizesColorsProducts->size_name}})" class="form-control mb-1 selectpicker" 
                        selected="{{$selectedSizesColorsProducts->product_name}} (Color: {{$selectedSizesColorsProducts->color_name}}) (Tamaño: {{$selectedSizesColorsProducts->size_name}})">
                            <option selected="selected" value="{{$selectedSizesColorsProducts->id}}">{{$selectedSizesColorsProducts->product_name}} (Color: {{$selectedSizesColorsProducts->color_name}}) (Tamaño: {{$selectedSizesColorsProducts->size_name}})</option>
                            @foreach ($allSizesColorsProducts as $key => $pr)
                                <option value="{{ $pr->id }}">{{$pr->product_name}} (Color: {{$pr->color_name}}) (Tamaño: {{$pr->size_name}})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-envelope-circle-check"></i> </span>
                        </div>
                        <label>Estado del envío:</label>
                        <select id="status_id" name="status_id" data-live-search="true" 
                        data-actions-box="true" data-header="Seleccione el nombre del estado del envío" 
                        title="{{$status->status_name}}" class="form-control mb-1 selectpicker" 
                        selected="{{$status->status_name}}" >
                            <option selected="selected" value="{{$status->status_id}}">{{$status->status_name}}</option>
                            @foreach ($allStatus as $key => $stat)
                                <option value="{{ $stat->status_id }}">{{$stat->status_name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <button type="submit" id="edit-shipment-submit" class="btn btn-primary btn-block">Editar envío</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('shipments.shipments-edit-js')
    @endsection

@endsection