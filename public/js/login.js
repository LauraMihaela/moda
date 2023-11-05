$('.center, .icon').on('click', function(e){
    $(".icon").css("opacity", "0");
});

$( ".container-fluid" ).hover(
    () => { //hover
        $(".icon").css("opacity", "0");
    }, 
    () => { //fuera del hover
      $(".icon").css("opacity", "1");
    }
);
