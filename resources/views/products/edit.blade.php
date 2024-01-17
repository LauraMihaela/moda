@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-product-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-dashboard')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.edit-product') {{$product->product_name}}</h4>

                <form action="{{route('products.update',$product->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-shirt"></i> </span>
                        </div>
                        <input required type="text" id="product_name" name="product_name" 
                        class="form-control" placeholder="@lang('messages.product-name')" value="{{$product->product_name}}">
                    </div>

                    {{-- Foto --}}
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-image"></i> </span>
                        </div>
                        <img src="{{asset('img/'.$product->picture)}}" alt="@lang('messages.product-image')" class="main-product-image">
                        <input type="file" id="picture" name="picture" class="form-control" placeholder="@lang('messages.product-picture')" accept=".png,.jpg,.jpeg,.bmp">
                        {{-- <label id="product-picture-label" for="picture">Elige una foto</label> --}}
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-comment-medical"></i> </span>
                        </div>
                        <textarea id="description" name="description" class="form-control" 
                        placeholder="@lang('messages.description')">{{$product->description}}</textarea>
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-arrow-down-1-9"></i> </span>
                        </div>
                        <input type="number" id="units" name="units" class="form-control" 
                        placeholder="@lang('messages.units')" value="{{$product->units}}">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-tag"></i> </span>
                        </div>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" 
                        placeholder="@lang('messages.price')" value="{{$product->price}}"><span>&#8364;</span>
                    </div>

                    @if (!$initialSizes->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                            </div>
                            <select required id="sizes" name="sizes[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="@lang('messages.select-the-product-sizes')" title="@lang('messages.sizes')"
                            class="selectpicker form-control mb-1">
                                @if (!$selectedSizes->isEmpty())
                                    @foreach ($selectedSizes as $selectedSize)
                                        <option selected="selected" value="{{$selectedSize->size_id}}">{{$selectedSize->size_name}}</option>
                                    @endforeach
                                @endif
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->size_id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-sizes-available')</p>
                            <button type="button" id="create-size" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-size')</button>
                        </div> 
                    @endif

                    @if (!$initialColors->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                            </div>
                            <select required id="colors" name="colors[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="@lang('messages.select-the-product-colors')" title="@lang('messages.colors')"
                            class="selectpicker form-control mb-1">
                                @if (!$selectedColors->isEmpty())
                                    @foreach ($selectedColors as $selectedColor)
                                        <option selected="selected" value="{{$selectedColor->color_id}}">{{$selectedColor->color_name}}</option>
                                    @endforeach
                                @endif
                                @foreach ($colors as $color)
                                    <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-colors-available')</p>
                            <button type="button" id="create-color" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-new-color')</button>
                        </div> 
                    @endif

                    {{-- Categorías --}}
                    @if (!$initialCategories->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-layer-group"></i> </span>
                            </div>
                            <select id="categories" name="categories[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="@lang('messages.select-the-product-categories')" title="@lang('messages.categories')"
                            class="selectpicker form-control mb-1">
                                @if (!$selectedCategories->isEmpty())
                                    @foreach ($selectedCategories as $selectedCategory)
                                        <option selected="selected" value="{{$selectedCategory->category_id}}">{{$selectedCategory->category_name}}</option>
                                    @endforeach
                                @endif
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-categories')</p>
                            <button type="button" id="create-category" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-new-category')</button>
                        </div> 
                    @endif

                    {{-- Fashion designer --}}
                    @if(!is_null($fashionDesigners))
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-user-tie"></i> </span>
                            </div>
                            <select required id="fashionDesigner" name="fashionDesigner" data-live-search="true" 
                            data-actions-box="true" data-header="@lang('messages.select-the-product-fashion-designer')" title="@lang('messages.fashion-designers')"
                            class="selectpicker form-control mb-1">
                                @if(!is_null($selectedFashionDesigner))
                                    <option selected="selected" value="{{$selectedFashionDesigner->fashion_designer_id}}">{{$selectedFashionDesigner->name}} ({{$selectedFashionDesigner->country}})</option>
                                @endif
                                @foreach ($fashionDesigners as $fashionDesigner)
                                    <option value="{{ $fashionDesigner['id'] }}">{{ $fashionDesigner['name'] }} ({{ $fashionDesigner['longCountry'] }})</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-fashion-designers-available')</p>
                            <button type="button" id="create-fashion-designer" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-new-fashion-designer')</button>
                        </div> 
                    @endif

                    <div class="form-group">
                        <button type="submit" id="edit-product-submit" class="btn btn-primary btn-block">@lang('messages.edit-product')</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('products.products-edit-js')
    @endsection

@endsection