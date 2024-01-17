@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-size-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-see-all-the-sizes')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.edit-the-size') {{$size->name}}</h4>

                <form action="{{route('sizes.update',$size->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                        </div>
                        <input required type="text" id="size_name" name="size_name" class="form-control" 
                        placeholder="@lang('messages.size-name')" value="{{$size->size_name}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" id="edit-size-submit" class="btn btn-primary btn-block">@lang('messages.edit-size')</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('sizes.sizes-edit-js')
    @endsection

@endsection