@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-fashionDesigner-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de diseñadores de moda</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de un diseñador de moda nuevo</h4>

                <form method="post" action="{{ url('fashionDesigners') }}" class="form-horizontal" enctype="multipart/form-data"> 
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-user-tie"></i> </span>
                        </div>
                        <input required type="text" id="name" name="name" class="form-control" placeholder="Nombre del diseñador de moda">
                    </div>

                      <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-earth-americas"></i> </span>
                        </div>
                        <select required id="country" name="country" class="form-control mb-1">
                            {{-- <option value="">Seleccione un país</option> --}}
                            @foreach ($countries as $key => $country)
                                <option value="{{ $key }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="form-group">
                        <button type="submit" id="create-product-submit" class="btn btn-primary btn-block">Crear diseñador de moda</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('fashionDesigners.fashionDesigners-create-js')
    @endsection

@endsection