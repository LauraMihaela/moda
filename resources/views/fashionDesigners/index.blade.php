@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
<p>Esto es la vista index del fashion designer</p>
@if(auth()->user()->role_id == config('constants.roles.admin_role'))
    <button type="button" id="create-fashion-designer" class="btn btn-primary btn-lg">Crear diseñador de moda</button>
@endif

<div class="card shadow mb-4" id="mainCardShadow">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary text-center">Lista de diseñadores de moda</h4>
    </div>

    <div class="card-body" id="mainCardBody">
      <div class="table-responsive">
      <table class="table table-bordered changableTable" id="mainTableFashionDesigner">
            <thead class="text-center">
                <tr class="text-center">
                    <th class="bg-primary">Nombre</th>
                    <th class="bg-primary">País</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @if (count($fashionDesigners)>0)
                  @foreach ($fashionDesigners as $designer)
                    <tr>
                      <td>{{ $designer['name'] }}</td>
                      <td>{{ $designer['country'] }}</td>
                    </tr>
                  @endforeach

                @else
                  <tr>
                    <td colspan="4">No existe ningún diseñador de moda
                    </td>
                  </tr>
                @endif
            </tbody>
        </table>
      </div>
    </div>
  </div>

@section('customScripts')
    @include('fashionDesigners.fashionDesigners-index-js')
@endsection

@endsection