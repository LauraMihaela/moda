@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-size-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de tamaños</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de un tamaño</h4>

                <form method="post" action="{{ url('sizes') }}" class="form-horizontal" enctype="multipart/form-data"> 
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                        </div>
                        <input required type="text" id="size_name" name="size_name" class="form-control" placeholder="Nombre del tamaño">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="create-size-submit" class="btn btn-primary btn-block">Crear tamaño</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('sizes.sizes-create-js')
    @endsection

@endsection