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
                    <span class="ml-1 mr-1">@lang('messages.size-colon')</span>
                    <select required id="sizes" name="sizes" data-live-search="true"
                    data-actions-box="true" data-header="@lang('messages.select-the-product-sizes')" title="@lang('messages.sizes')"
                    class="form-control mb-1">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->size_id }}">{{ $size->size_name }}</option>
                        @endforeach
                    </select>
                </div> 
            @else
                <div class="form-group input-group m-2">
                    <p>@lang('messages.the-product-does-not-have-sizes-available')</p>
                </div> 
            @endif

            @if (!$colors->isEmpty())
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                    </div>
                    <span class="ml-1 mr-1">@lang('messages.color-colon')</span>
                    <select required id="colors" name="colors" data-live-search="true" 
                    data-actions-box="true" data-header="@lang('messages.select-a-color-in-the-product')" title="@lang('messages.colors')"
                    class="form-control mb-1">
                        @foreach ($colors as $color)
                            <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                        @endforeach
                    </select>
                </div> 
            @else
                <div class="form-group input-group m-2">
                    <p>@lang('messages.the-product-does-not-have-colors-available')</p>
                </div> 
            @endif

            <div class="form-group float-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalCart">@lang('messages.close')</button>
                {{-- <button type="submit" class="btn btn-primary cart-product-submit" id="saveModalCart"><i class="fa fa-save"></i>&ensp;Añadir producto al carrito</button> --}}
                <button type="submit" class="btn btn-primary cart-product-submit" id="saveModalCart"><i class="fa fa-save"></i>&ensp;@lang('messages.add-product-to-cart') {{$product->product_name}}</button>
            </div>    
        </form>


    </div> 

    @section('customScripts')
        @include('products.products-show-product-cart-details-js')
    @endsection

@endsection