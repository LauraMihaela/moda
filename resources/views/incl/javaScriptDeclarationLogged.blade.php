         {{-- Bootstrap JavaScript CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        {{-- Jquery JavaScript CDN --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        {{-- Font awesome JavaScript CDN --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
        {{-- DataTables JavaScript CDN. Obtenido de: https://cdn.datatables.net/--}}
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        {{-- DataTables JavaScript CDN for buttons--}}
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/application.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/menu.js') }}"></script>
        @include('incl.javaScriptGlobals')