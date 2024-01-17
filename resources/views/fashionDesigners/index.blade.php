@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
@if(auth()->user()->role_id == config('constants.roles.admin_role'))
    <button type="button" id="create-fashion-designer" class="btn btn-primary btn-lg">@lang('messages.create-new-fashion-designer')</button>
@endif

<div class="card shadow mb-4" id="mainCardShadow">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary text-center">@lang('messages.fashion-designers-list')</h4>
    </div>

    <div class="card-body" id="mainCardBody">
      <div class="table-responsive">
      <table class="table table-bordered changableTable" id="mainTableFashionDesigner">
            <thead class="text-center">
                <tr class="text-center">
                    <th class="bg-primary">@lang('messages.name')</th>
                    <th class="bg-primary">@lang('messages.country')</th>
                    <th class="bg-primary">@lang('messages.actions')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
    </div>
  </div>

@section('customScripts')
    @include('fashionDesigners.fashionDesigners-index-js')
@endsection

@endsection