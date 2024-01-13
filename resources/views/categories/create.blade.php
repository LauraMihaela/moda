@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-category-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de categorías</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de una categoría</h4>

                <form method="post" action="{{ url('categories') }}" class="form-horizontal" enctype="multipart/form-data"> 
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-layer-group"></i> </span>
                        </div>
                        <input required type="text" id="category_name" name="category_name" class="form-control" placeholder="Nombre de la categoría">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="create-category-submit" class="btn btn-primary btn-block">Crear categoría</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('categories.categories-create-js')
    @endsection

@endsection