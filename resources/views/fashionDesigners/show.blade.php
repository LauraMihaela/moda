@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-fashionDesigner-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de diseñadores de moda</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Diseñador de moda {{$fashionDesigner->name}}</h4>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-user-tie"></i> </span>
                        </div>
                        <input required type="text" id="name" name="name" class="form-control" 
                        placeholder="Nombre del diseñador de moda" value="{{$fashionDesigner->name}}"
                        readonly>
                    </div>

                      <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-earth-americas"></i> </span>
                        </div>
                        <select required id="show-country" data-country="{{$fashionDesigner->country}}" name="country" class="form-control mb-1" 
                        >
                            {{-- <option value="">Seleccione un país</option> --}}
                            @foreach ($countries as $key => $country)
                                <option disabled value="{{ $key }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div> 

                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('fashionDesigners.fashionDesigners-show-js')
    @endsection

@endsection