@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-color-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-see-all-the-colors')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.color') {{$color->color_name}}</h4>
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                        </div>
                        <input required type="text" id="color_name" name="color_name" class="form-control" 
                        placeholder="@lang('messages.color-name')" value="{{$color->color_name}}"
                        readonly>
                    </div>
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('colors.colors-show-js')
    @endsection

@endsection