@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')



    @if(empty(auth()->user()))
        <p>@lang('messages.hello')</p>
    @else
        <p>@lang('messages.hello') {{ auth()->user()->username }} </p>
    @endif
    {{-- {{ dd(config('constants.roles.client_role'))}} --}}

    @if(auth()->user()->role_id !== config('constants.roles.client_role'))
        <div class = "btn-group">
            <button type="button" id="create-product" class="create-product btn btn-primary btn-lg mr-2">@lang('messages.create-product')</button>
            <button type="button" id="see-sizes" class="see-sizes btn btn-primary btn-lg mr-2">@lang('messages.see-sizes')</button>
            <button type="button" id="see-colors" class="see-colors btn btn-primary btn-lg mr-2">@lang('messages.see-colors')</button>
        </div>
    @endif  

    <div class="card shadow mb-4" id="mainCardShadow">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary text-center">@lang('messages.products-list')</h4>
        </div>
    
        <div class="card-body" id="mainCardBody">
          <div class="table-responsive">
          <table class="table table-bordered changableTable" id="mainTableProducts">
                <thead class="text-center">
                    <tr class="text-center">
                        <th class="bg-primary">@lang('messages.product-name')</th>
                        <th class="bg-primary">@lang('messages.picture')</th>
                        <th class="bg-primary">@lang('messages.price')</th>
                        <th class="bg-primary">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
          </div>
        </div>
    </div>

    {{-- Se va a incluir al final --}}
    @section('customScripts')
        @include('dashboard.dashboard-index-js')
    @endsection
@endsection