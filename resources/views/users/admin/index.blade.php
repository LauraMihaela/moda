@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
@if(auth()->user()->role_id == config('constants.roles.admin_role'))
  <div class = "btn-group">
    <button type="button" id="create-admin" class="btn btn-primary btn-lg m-3">Crear nuevo administrador</button>
    <button type="button" id="back-to-global-users-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de usuarios</button>
</div>
@endif

<div class="card shadow mb-4" id="mainCardShadow">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary text-center">Lista de usuarios de tipo administrador</h4>
    </div>

    <div class="card-body" id="mainCardBody">
      <div class="table-responsive">
      <table class="table table-bordered changableTable" id="mainTableAdmins">
            <thead class="text-center">
                <tr class="text-center">
                    <th class="bg-primary">Nombre del usuario administrador</th>
                    <th class="bg-primary">Email</th>
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
    @include('users.admin.admin-index-js')
@endsection

@endsection