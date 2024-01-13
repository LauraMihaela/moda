@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-shipment-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de envíos</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Envío {{$shipment->id}}:</h4>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-circle-user"></i> </span>
                        </div>
                        <label>Nombre de usuario:</label>
                        <input required type="text" id="username" name="username" class="form-control" 
                        placeholder="Nombre de usuario del cliente" value="{{$shipmentUser->username}}"
                        readonly>
                    </div>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-bag-shopping"></i> </span>
                        </div>
                        <label>Nombre del producto:</label>
                        <input required type="text" id="product_name" name="product_name" class="form-control" 
                        placeholder="Nombre del producto" value="{{$sizes_colors_products->product_name}}"
                        readonly>
                    </div>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                        </div>
                        <label>Tamaño del producto:</label>
                        <input required type="text" id="size_name" name="size_name" class="form-control" 
                        placeholder="Tamaño del producto" value="{{$sizes_colors_products->size_name}}"
                        readonly>
                    </div>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                        </div>
                        <label>Color del producto:</label>
                        <input required type="text" id="color_name" name="color_name" class="form-control" 
                        placeholder="Color del producto" value="{{$sizes_colors_products->color_name}}"
                        readonly>
                    </div>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-envelope-circle-check"></i> </span>
                        </div>
                        <label>Estado del envío:</label>
                        <input required type="text" id="status_name" name="status_name" class="form-control" 
                        placeholder="Nombre del estado del envío" value="{{$status->status_name}}"
                        readonly>
                    </div>
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('shipments.shipments-show-js')
    @endsection

@endsection