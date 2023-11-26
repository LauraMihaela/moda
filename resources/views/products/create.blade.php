@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-dashboard" class="btn btn-primary btn-lg m-3">Volver al Dashboard</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de un producto nuevo</h4>

                <form method="post" action="{{ url('products') }}" class="form-horizontal" enctype="multipart/form-data"> 
                {{-- {{ Form::open(array('url' => 'products', 'method' => 'POST', 'class' => 'form-horizontal')) }}           --}}
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-shirt"></i> </span>
                        </div>
                        <input required type="text" id="product_name" name="product_name" class="form-control" placeholder="Nombre de producto">
                    </div>

                    {{-- Foto --}}
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-image"></i> </span>
                        </div>
                        <input type="file" id="picture" name="picture" class="form-control" placeholder="Foto de producto" accept=".png,.jpg,.jpeg,.bmp">
                        {{-- <label id="product-picture-label" for="picture">Elige una foto</label> --}}
                    </div>

                      <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-comment-medical"></i> </span>
                        </div>
                        <textarea id="description" name="description" class="form-control" placeholder="Descripción "></textarea>
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-arrow-down-1-9"></i> </span>
                        </div>
                        <input type="number" id="units" name="units" class="form-control" placeholder="Unidades">
                    </div>

                    {{-- Fashion designer --}}

                    <div class="form-group">
                        <button type="submit" id="register-submit" class="btn btn-primary btn-block">Crear producto</button>
                    </div>    
                {{-- {{ Form::close() }}  --}}
                </form>
            </article>
        </div> <!-- card.// -->
    </div> 

    @section('customScripts')
        @include('products.products-create-js')
    @endsection

@endsection