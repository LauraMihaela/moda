@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-product-index" class="btn btn-primary btn-lg m-3">Volver a la pantalla principal</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Color {{$product->product_name}}</h4>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                        </div>
                        <input required type="text" id="product_name" name="product_name" class="form-control" 
                        placeholder="Nombre del producto" value="{{$product->product_name}}"
                        readonly>
                    </div>
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('products.products-show-js')
    @endsection

@endsection