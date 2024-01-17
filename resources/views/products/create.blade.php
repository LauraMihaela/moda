@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-dashboard" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-dashboard')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.creation-of-a-new-product')</h4>

                <form method="post" action="{{ url('products') }}" class="form-horizontal" enctype="multipart/form-data"> 
                {{-- {{ Form::open(array('url' => 'products', 'method' => 'POST', 'class' => 'form-horizontal')) }}           --}}
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-shirt"></i> </span>
                        </div>
                        <input required type="text" id="product_name" name="product_name" class="form-control" placeholder="@lang('messages.product-name')">
                    </div>

                    {{-- Foto --}}
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-image"></i> </span>
                        </div>
                        <input type="file" id="picture" name="picture" class="form-control" placeholder="@lang('messages.product-picture')" accept=".png,.jpg,.jpeg,.bmp">
                        {{-- <label id="product-picture-label" for="picture">Elige una foto</label> --}}
                    </div>

                      <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-comment-medical"></i> </span>
                        </div>
                        <textarea id="description" name="description" class="form-control" placeholder="@lang('messages.description')"></textarea>
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-arrow-down-1-9"></i> </span>
                        </div>
                        <input type="number" id="units" name="units" class="form-control" placeholder="@lang('messages.units')">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-tag"></i> </span>
                        </div>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="@lang('messages.price')">
                    </div>

                    @if (!$sizes->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                            </div>
                            <select required id="sizes" name="sizes[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="@lang('messages.select-the-product-sizes')" title="@lang('messages.sizes')"
                            class="selectpicker form-control mb-1">
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-sizes-available')</p>
                            <button type="button" id="create-size" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-size')</button>
                        </div> 
                    @endif

                    @if (!$colors->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                            </div>
                            <select required id="colors" name="colors[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="@lang('messages.select-the-product-colors')" title="@lang('messages.colors')"
                            class="selectpicker form-control mb-1">
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-colors-available')</p>
                            <button type="button" id="create-color" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-new-color')</button>
                        </div> 
                    @endif

                    @if (!$categories->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-layer-group"></i> </span>
                            </div>
                            <select required id="categories" name="categories[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="@lang('messages.select-the-product-categories')" title="@lang('messages.categories')"
                            class="selectpicker form-control mb-1">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>@lang('messages.there-are-no-categories-available')</p>
                            <button type="button" id="create-category" class="btn btn-secondary btn-sm ml-1 mr-2">@lang('messages.create-new-category')</button>
                        </div> 
                    @endif

                    {{-- Fashion designer --}}
                    @if(!is_null($fashionDesigners))
                        {{-- Select del fashion designer --}}
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-user-tie"></i> </span>
                            </div>
                            <select required id="fashionDesigner" name="fashionDesigner" data-live-search="true" 
                            data-actions-box="true" data-header="@lang('messages.select-the-product-fashion-designer')" title="@lang('messages.fashion-designers')"
                            class="selectpicker form-control mb-1">
                                @foreach ($fashionDesigners as $fashionDesigner)
                                    <option value="{{ $fashionDesigner['id'] }}">{{ $fashionDesigner['name'] }}, {{ $fashionDesigner['longCountry'] }}</option>
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
                        <button type="submit" id="register-submit" class="btn btn-primary btn-block">@lang('messages.create-product')</button>
                    </div>    
                {{-- {{ Form::close() }}  --}}
                </form>
                
            </article>
        </div> <!-- card.// -->
        @if(is_null($fashionDesigners))
            <div>
                <p>@lang('messages.there-are-no-fashion-designers')</p>
                <button type="button" id="create-fashion-designer" class="btn btn-primary">@lang('messages.create-new-fashion-designer')</button>
            </div>
        @endif
    </div> 

    @section('customScripts')
        @include('products.products-create-js')
    @endsection

@endsection