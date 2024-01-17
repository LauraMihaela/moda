@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-shipment-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-see-all-the-shipments')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.create-a-shipment')</h4>

                <form method="post" action="{{ url('shipments') }}" class="form-horizontal" enctype="multipart/form-data"> 
                @csrf
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa-solid fa-circle-user"></i> </span>
                    </div>
                    <label>@lang('messages.username-colon')</label>
                    <select required id="client_id" name="client_id" data-live-search="true" 
                    data-actions-box="true" data-header="@lang('messages.select-username')" 
                    title="@lang('messages.select-username')" class="form-control mb-1 selectpicker">
                        @foreach ($allClients as $key => $client)
                            <option value="{{ $client->client_id }}">{{ $client->username }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa-solid fa-bag-shopping"></i> </span>
                    </div>
                    <label>@lang('messages.product-to-be-bought-colon')</label>
                    <select required="sizes_colors_products_id" name="sizes_colors_products_id" data-live-search="true" 
                    data-actions-box="true" data-header="@lang('messages.choose-a-product')" 
                    title="@lang('messages.choose-a-product')" class="form-control mb-1 selectpicker">
                        @foreach ($allSizesColorsProducts as $key => $pr)
                            <option value="{{ $pr->id }}">{{$pr->product_name}} (Color: {{$pr->color_name}}) (@lang('messages.size-colon') {{$pr->size_name}})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa-solid fa-envelope-circle-check"></i> </span>
                    </div>
                    <label>@lang('messages.product-status-colon')</label>
                    <select required id="status_id" name="status_id" data-live-search="true" 
                    data-actions-box="true" data-header="@lang('messages.select-the-status-name')" 
                    title="@lang('messages.select-the-status-name')" class="form-control mb-1 selectpicker" >
                        @foreach ($allStatus as $key => $stat)
                            <option value="{{ $stat->status_id }}">{{$stat->status_name}}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="form-group">
                        <button type="submit" id="create-shipment-submit" class="btn btn-primary btn-block">@lang('messages.create-shipment')</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('shipments.shipments-create-js')
    @endsection

@endsection