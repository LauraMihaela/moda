@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-color-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de colores</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de un color</h4>

                <form method="post" action="{{ url('colors') }}" class="form-horizontal" enctype="multipart/form-data"> 
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                        </div>
                        <input required type="text" id="color_name" name="color_name" class="form-control" placeholder="Nombre del color">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="create-color-submit" class="btn btn-primary btn-block">Crear color</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.admin.admin-create-js')
    @endsection

@endsection