@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-category-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de categorías</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Color {{$category->category_name}}</h4>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-layer-group"></i> </span>
                        </div>
                        <input required type="text" id="category_name" name="category_name" class="form-control" 
                        placeholder="Nombre de la categoría" value="{{$category->category_name}}"
                        readonly>
                    </div>
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('categories.categories-show-js')
    @endsection

@endsection