@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-category-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-see-all-the-categories')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.edit-the-category') {{$category->name}}</h4>

                <form action="{{route('categories.update',$category->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-layer-group"></i> </span>
                        </div>
                        <input required type="text" id="category_name" name="category_name" class="form-control" 
                        placeholder="@lang('messages.category-name')" value="{{$category->category_name}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" id="edit-category-submit" class="btn btn-primary btn-block">@lang('messages.edit-category')</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('categories.categories-edit-js')
    @endsection

@endsection