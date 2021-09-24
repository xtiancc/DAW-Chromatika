$('document').ready(function() {

    // Función muestra carga durante 3.1 segundo y posteriormente muestra la tabla
    $('#submit_filtro').submit(setTimeout(function() {
        $('.res_loader').fadeOut("slow");
        $('.res_tabla').delay(600).fadeIn("slow");
    }, 2500));

    // Función que cambia el color a algunos de los iconos de font-awesome
    $('.fa-rb').hover(function() {
        var colores = ['#0275d8','#5bc0ce','#5cb85c','#f0ad4e','#d9534f'];
        var r_color = Math.floor(Math.random() * 5);
        
        $(this).css('color', colores[r_color]);
    }, function() {
        $(this).css('color', '#212529');
        
    });
    
    // Función para agregar scroll smooth a los links que lo requieran
    $("a").click(function(event) {
        
        if (this.hash !== "") {
        event.preventDefault();
        var hash = this.hash;

        $('html, body').animate({ scrollTop: $(hash).offset().top }, 800, function(){
            
        window.location.hash = hash;
        
        });
        
    }});
    
});

// Función necesaria para el popover de información
$(function() {
    $('[data-toggle="popover"]').popover()
});
