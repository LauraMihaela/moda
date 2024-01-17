<!DOCTYPE html>
<html>
    <head>
        @include('incl.headLogin')
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    </head>
    <body>
        <div class="d-flex justify-content-center">
            <button type="button" id="login-button" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-log-in-site')</button>
        </div>   

        <div class="container">
            <div class="card bg-light">
                <article class="card-body mx-auto">
                    <h4 class="card-title mt-3 text-center">@lang('messages.create-a-new-user')</h4>

                    @include ('incl.alertsContainters')

                    {{ Form::open(array('url' => 'user/client/store', 'method' => 'POST', 'class' => 'form-horizontal')) }}          

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                            </div>
                            <input required type="text" id="username" name="username" class="form-control" placeholder="@lang('messages.username')">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                            </div>
                            <input required type="email" id="email" name="email" class="form-control" placeholder="@lang('messages.email')">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>
                            <input required type="text" id="name" name="name" class="form-control" placeholder="@lang('messages.name')">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>
                            <input required type="text" id="lastname" name="lastname" class="form-control" placeholder="@lang('messages.lastname')">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                            </div>
                            <textarea id="address" name="address" class="form-control" placeholder="@lang('messages.address')"></textarea>
                        </div> 
                
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend mr-2 pr-2">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            <input required id="password" name="password" class="form-control input-lg input-ml" 
                            placeholder="@lang('messages.create-password')" type="password" autocomplete="off">
                        </div> 

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            {{-- El nombre debe ser password_confirmation para que laravel realice la
                                validación de que ambas contraseñas son iguales --}}
                            <input required id="password_confirmation" name="password_confirmation" class="form-control"
                             placeholder="@lang('messages.repeat-the-password')" type="password" 
                             autocomplete="off" aria-describedby="inputGroupPrepend">
                        </div>

                        <div class="form-group">
                            <button type="submit" id="register-submit" class="btn btn-primary btn-block">@lang('messages.create-new-account')</button>
                        </div>    
                    {{ Form::close() }} 
                </article>
            </div> <!-- card.// -->
        </div> 

        @include('incl.modals')
        @include('incl.javaScriptDeclarationLogin')
        <script type="text/javascript" src="{{ asset('js/register.js') }}"></script>
    </body> 
</html>
