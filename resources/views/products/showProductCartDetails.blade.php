@extends('layout.layout-without-nav')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')

    <div class="container">

        <h4 class="card-title mt-3 text-center">Producto {{$product->product_name}}</h4>
        <form id="form-product-cart" {{route('products.addToCart',$product->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
            @csrf

            <input type="hidden" id="productId" name="productId" value="{{ $product->id }}"/>

            @if (!$sizes->isEmpty())
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                    </div>
                    <span class="ml-1 mr-1">Tamaño:</span>
                    <select required id="sizes" name="sizes" data-live-search="true"
                    data-actions-box="true" data-header="Seleccione los tamaños del producto" title="Tamaños"
                    class="form-control mb-1">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->size_id }}">{{ $size->size_name }}</option>
                        @endforeach
                    </select>
                </div> 
            @else
                <div class="form-group input-group m-2">
                    <p>El producto no tiene tamaños disponibles.</p>
                </div> 
            @endif

            @if (!$colors->isEmpty())
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                    </div>
                    <span class="ml-1 mr-1">Color:</span>
                    <select required id="colors" name="colors" data-live-search="true" 
                    data-actions-box="true" data-header="Seleccione el color del producto" title="Colores"
                    class="form-control mb-1">
                        @foreach ($colors as $color)
                            <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                        @endforeach
                    </select>
                </div> 
            @else
                <div class="form-group input-group m-2">
                    <p>El producto no tiene colores disponibles.</p>
                </div> 
            @endif

            <div class="form-group float-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalCart">Cerrar</button>
                <button type="submit" class="btn btn-primary cart-product-submit" id="saveModalCart"><i class="fa fa-save"></i>&ensp;Añadir producto al carrito</button>
            </div>    
        </form>


    </div> 

    @section('customScripts')
        @include('products.products-show-product-cart-details-js')
    @endsection

@endsection