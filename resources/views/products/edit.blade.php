@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-product-index" class="btn btn-primary btn-lg m-3">Volver a la pantalla principal</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Edición del producto {{$product->product_name}}</h4>

                <form action="{{route('products.update',$product->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-shirt"></i> </span>
                        </div>
                        <input required type="text" id="product_name" name="product_name" 
                        class="form-control" placeholder="Nombre de producto" value="{{$product->product_name}}">
                    </div>

                    {{-- Foto --}}
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-image"></i> </span>
                        </div>
                        <img src="{{asset('img/'.$product->picture)}}" alt="Imagen de producto" class="main-product-image">
                        <input type="file" id="picture" name="picture" class="form-control" placeholder="Foto de producto" accept=".png,.jpg,.jpeg,.bmp">
                        {{-- <label id="product-picture-label" for="picture">Elige una foto</label> --}}
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-comment-medical"></i> </span>
                        </div>
                        <textarea id="description" name="description" class="form-control" 
                        placeholder="Descripción">{{$product->description}}</textarea>
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-arrow-down-1-9"></i> </span>
                        </div>
                        <input type="number" id="units" name="units" class="form-control" 
                        placeholder="Unidades" value="{{$product->units}}">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-tag"></i> </span>
                        </div>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" 
                        placeholder="Precio" value="{{$product->price}}"><span>&#8364;</span>
                    </div>

                    @if (!$sizes->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                            </div>
                            <select required id="sizes" name="sizes[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="Seleccione los tamaños del producto" title="Tamaños"
                            class="selectpicker form-control mb-1">
                                @foreach ($selectedSizes as $selectedSize)
                                    <option selected="selected" value="{{$selectedSize->size_id}}">{{$selectedSize->size_name}}</option>
                                @endforeach
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>No hay tamaños disponibles. Puede crear uno nuevo desde aquí</p>
                            <button type="button" id="create-size" class="btn btn-secondary btn-sm ml-1 mr-2">Crear nuevo tamaño</button>
                        </div> 
                    @endif

                    @if (!$colors->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-palette"></i> </span>
                            </div>
                            <select required id="colors" name="colors[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="Seleccione los colores del producto" title="Colores"
                            class="selectpicker form-control mb-1">
                                @foreach ($selectedColors as $selectedColor)
                                    <option selected="selected" value="{{$selectedColor->scolor_id}}">{{$selectedColor->color_name}}</option>
                                @endforeach
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>No hay colores disponibles. Puede crear uno nuevo desde aquí</p>
                            <button type="button" id="create-color" class="btn btn-secondary btn-sm ml-1 mr-2">Crear nuevo color</button>
                        </div> 
                    @endif

                    {{-- Fashion designer --}}
                    @if (!$fashionDesigners->isEmpty())
                        {{-- Select del fashion designer --}}
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-user-tie"></i> </span>
                            </div>
                            <select required id="fashionDesigner" name="fashionDesigner" data-live-search="true" 
                            data-actions-box="true" data-header="Seleccione el diseñador de moda del producto" title="Diseñadores de moda"
                            class="selectpicker form-control mb-1">
                                @foreach ($selectedFashionDesigners as $selectedFashionDesigner)
                                    <option selected="selected" value="{{$selectedFashionDesigner->fashion_designer_id}}">{{$selectedFashionDesigner->name}} ({{$selectedFashionDesigner->country}})</option>
                                @endforeach
                                @foreach ($fashionDesigners as $fashionDesigner)
                                    <option value="{{ $fashionDesigner->id }}">{{ $fashionDesigner->name }} ({{ $fashionDesigner->country}})</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group input-group m-2">
                            <p>No hay diseñadores de moda disponibles. Puede crear uno nuevo desde aquí</p>
                            <button type="button" id="create-fashion-designer" class="btn btn-secondary btn-sm ml-1 mr-2">Crear nuevo diseñador de moda</button>
                        </div> 
                    @endif


                    <div class="form-group">
                        <button type="submit" id="edit-product-submit" class="btn btn-primary btn-block">Editar producto</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('products.products-edit-js')
    @endsection

@endsection