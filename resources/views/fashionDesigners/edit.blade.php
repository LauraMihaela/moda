@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-fashionDesigner-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de diseñadores de moda</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Edición del diseñador de moda {{$fashionDesigner->name}}</h4>

                <form action="{{route('fashionDesigners.update',$fashionDesigner->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-user-tie"></i> </span>
                        </div>
                        <input required type="text" id="name" name="name" class="form-control" 
                        placeholder="Nombre del diseñador de moda" value="{{$fashionDesigner->name}}">
                    </div>

                      <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-earth-americas"></i> </span>
                        </div>
                        <select required id="country" name="country" data-live-search="true" 
                        data-actions-box="true" data-header="Seleccione un pais" 
                        title="{{$fashionDesigner->country}}" class="form-control mb-1 selectpicker" 
                        selected="{{$fashionDesigner->country}}" >
                            {{-- <option value="">Seleccione un país</option> --}}
                            @foreach ($countries as $key => $country)
                                <option value="{{ $key }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="form-group">
                        <button type="submit" id="create-product-submit" class="btn btn-primary btn-block">Editar diseñador de moda</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('fashionDesigners.fashionDesigners-edit-js')
    @endsection

@endsection