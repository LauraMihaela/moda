{{-- Alert para errores que provienen de controllers --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Alert para mensajes que provienen de controllers --}}
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

{{-- Alert para errores --}}
<div id="error-container" class="alert alert-danger text-center dNone"></div>
{{-- Alert para mensajes de información --}}
<div id="message-container" class="alert alert-danger text-center dNone"></div>