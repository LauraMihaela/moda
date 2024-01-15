@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
@if(auth()->user()->role_id !== config('constants.roles.client_role'))
  <div class = "btn-group">
    <button type="button" id="create-color" class="btn btn-primary btn-lg mr-2">Crear nuevo color</button>
    <button type="button" id="back-to-dashboard" class="btn btn-primary btn-lg mr-2">Volver a la página de inicio</button>
  </div>
@endif

<div class="card shadow mb-4" id="mainCardShadow">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary text-center">Lista de colores</h4>
    </div>

    <div class="card-body" id="mainCardBody">
      <div class="table-responsive">
      <table class="table table-bordered changableTable" id="mainTableColors">
            <thead class="text-center">
                <tr class="text-center">
                    <th class="bg-primary">Nombre del color</th>
                    <th class="bg-primary">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
    </div>
  </div>

@section('customScripts')
    @include('colors.colors-index-js')
@endsection

@endsection