{{-- Se utiliza de forma global en toda la aplicación --}}
<script>
    let _publicURL = location.href.includes('public') ? location.href.substring(0, location.href.indexOf('public')+7):
    location.href.match(/^(http(s)?:\/\/([^\/$]+))/);

        
    
</script>