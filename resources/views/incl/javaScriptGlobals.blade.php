{{-- Se utiliza de forma global en toda la aplicación --}}
<script>
    let _publicURL = location.href.includes('public') ? location.href.substring(0, location.href.indexOf('public')+7):
    location.href.match(/^(http(s)?:\/\/([^\/$]+))/);
    // Obtener idioma actual
    let _lang = "{{ getLang() }}";
    let _longLanguage = "{{ getLangLong() }}";
    let _langFlag = _lang;
    if (_lang == "en"){
        _langFlag = "us";
    }
    let _langDt = "";
    switch(_lang){
        case "es":
            _langDt = "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json";
            break;
        case "en":
            _langDt = "";
            break;
        case "ro":
            _langDt = "//cdn.datatables.net/plug-ins/1.13.7/i18n/ro.json";
            break;
        default:
            _langDt = "";
            break;
      }

        
    
</script>