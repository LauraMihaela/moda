@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-dashboard" class="btn btn-primary btn-lg m-3">Volver al Dashboard</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de un producto nuevo</h4>

                <form method="post" action="{{ url('products') }}" class="form-horizontal" enctype="multipart/form-data"> 
                {{-- {{ Form::open(array('url' => 'products', 'method' => 'POST', 'class' => 'form-horizontal')) }}           --}}
                @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-shirt"></i> </span>
                        </div>
                        <input required type="text" id="product_name" name="product_name" class="form-control" placeholder="Nombre de producto">
                    </div>

                    {{-- Foto --}}
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-image"></i> </span>
                        </div>
                        <input type="file" id="picture" name="picture" class="form-control" placeholder="Foto de producto" accept=".png,.jpg,.jpeg,.bmp">
                        {{-- <label id="product-picture-label" for="picture">Elige una foto</label> --}}
                    </div>

                      <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-comment-medical"></i> </span>
                        </div>
                        <textarea id="description" name="description" class="form-control" placeholder="Descripción "></textarea>
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-arrow-down-1-9"></i> </span>
                        </div>
                        <input type="number" id="units" name="units" class="form-control" placeholder="Unidades">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa-solid fa-tag"></i> </span>
                        </div>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="Precio">
                    </div>

                    @if (!$sizes->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-up-right-and-down-left-from-center"></i> </span>
                            </div>
                            <select required id="sizes" name="sizes[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="Seleccione los tamaños del producto" title="Tamaños"
                            class="selectpicker form-control mb-1">
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

                    @if (!$categories->isEmpty())
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa-solid fa-layer-group"></i> </span>
                            </div>
                            <select required id="categories" name="categories[]" data-live-search="true" multiple="multiple"
                            data-actions-box="true" data-header="Seleccione las categorías del producto" title="Categorías"
                            class="selectpicker form-control mb-1">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @else
                        <div class="form-group input-group m-2">
                            <p>No hay categorías disponibles. Puede crear una nuevo desde aquí</p>
                            <button type="button" id="create-category" class="btn btn-secondary btn-sm ml-1 mr-2">Crear nuevo color</button>
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
                            data-actions-box="true" data-header="Seleccione el diseñador de moda del producto" title="Diseñadores de moda"
                            class="selectpicker form-control mb-1">
                                @foreach ($fashionDesigners as $fashionDesigner)
                                    <option value="{{ $fashionDesigner['id'] }}">{{ $fashionDesigner['name'] }}, {{ $fashionDesigner['longCountry'] }}</option>
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
                        <button type="submit" id="register-submit" class="btn btn-primary btn-block">Crear producto</button>
                    </div>    
                {{-- {{ Form::close() }}  --}}
                </form>
                
            </article>
        </div> <!-- card.// -->
        @if(is_null($fashionDesigners))
            <div>
                <p>No hay ningún fashion designer. Si quiere puede crearlo.</p>
                <button type="button" id="create-fashion-designer" class="btn btn-primary">Crear diseñador de moda</button>
            </div>
        @endif
    </div> 

    @section('customScripts')
        @include('products.products-create-js')
    @endsection

@endsection