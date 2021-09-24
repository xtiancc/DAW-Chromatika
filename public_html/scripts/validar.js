$('document').ready(function() {

    // Optimización del mensaje para algunas normas
    $.validator.messages.required = "<small>Por favor, complete el campo.</small>";

    // MÉTODOS EXPRESIONES REGULARES
    
    // Solamente permitir letras
    $.validator.addMethod('soloLetra', function(value, element) {
        return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/.test(value);
    }, "<small>El campo únicamente puede carácteres alfabéticos.</small>");

    // Solamente permitir letras y numeros
    $.validator.addMethod('letraNum', function(value, element) {
        return this.optional(element) || /^[A-Za-z0-9]+$/.test(value);
    }, "<small>El campo únicamente puede carácteres alfanuméricos.</small>");

    // No permitir espacios en usuario, contraseña y e-mail
    $.validator.addMethod('noEspacio', function(value, element) {
        return this.optional(element) || /^\S+$/.test(value);
    }, "<small>El campo no debe contener espacios en blanco.</small>");

    // Contraseña. Mínimo una mayúscula, una minuscula y un número
    $.validator.addMethod('verPass', function(value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/.test(value);
    }, "<small>Recuerde, su contraseña debe de incluir al menos una mayúscula, una minúscula y un número.</small>");

    // E-mail correcto (revisa que el usuario ponga .com, .es, etc. y no como el método email corriente)
    $.validator.addMethod('nuevoMail', function(value, element) {
        return this.optional(element) || /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(value);
    }, "<small>Inserte un e-mail válido.</small>");

    // Codigo postal (Cinco números)
    $.validator.addMethod('codigoPostal', function(value, element) {
        return this.optional(element) || /^\d{5}$/.test(value);
    }, "<small>Inserte un e-mail válido.</small>");

    // http://w3.unpocodetodo.info/utiles/regex-ejemplos.php?type=psw 
    //http://jquery-manual.blogspot.com/2013/09/expresiones-regulares-con-pregmatch.html?m=1


    // VALIDACIÓN DE FORMULARIOS

    // Formulario de registro
    $("#submit_register").on("click", function(){

        $("#register").validate({
            rules: {
                register_u: { required: true, noEspacio: true, letraNum: true, minlength: 6 },
                register_m: { required: true, noEspacio: true, nuevoMail: true },
                register_p: { required: true, noEspacio: true, minlength: 8, verPass: true },
                register_t: { required: true },
                register_tc: { required: true }
            },
            messages: {
                register_u: {
                    minlength: "<small>Su nombre de usuario debe superar los 6 caracteres.</small>"
                },
                register_p: {
                    minlength: "<small>Su contraseña debe superar los 8 caracteres.</small>"
                },
                register_tc: {
                    required: "<small>Antes de proceder con el registro, debe de leer detenidamente el acuerdo.<small>"
                },
                
            }
        });

    });

    // Formulario de login
    $("#submit_login").on("click", function(){

        $("#login").validate({

            rules: {
                login_u: { required: true, noEspacio: true, letraNum: true, minlength: 6 },
                login_p: { required: true, noEspacio: true, minlength: 8, verPass: true } 
            },
            messages: {
                login_u: { 
                    minlength: "<small>Su nombre de usuario debe superar los 6 caracteres.</small>"
                },
                login_p: {
                    minlength: "<small>Su contraseña debe superar los 8 caracteres.</small>"
                }
            }

        });

    });

    //  Formulario de datos personales
    $("#submit_personal").on("click", function(){

        $("#personal").validate({

            rules: {
                fam_prof: { required: true },
                diseño: { required: true },
                nombre: { required: true, soloLetra: true },
                apellidos: { required: true, soloLetra: true },
                direccion: { required: true },
                localidad: { required: true, soloLetra: true },
                cod_pais: { required: true },
                cod_postal: { required: true, codigoPostal: true },

            },
            messages: {
                cod_postal: { 
                    codigoPostal: "<small>Inserte un código postal válido.</small>"
                }
            }

        });

    });

    //  Formulario de experiencia
    $("#submit_exp").on("click", function(){

        $("#experience").validate({

            rules: {
                e_nombre: { required: true },
                e_puesto: { required: true },
                e_localidad: { required: true, soloLetra: true },
                e_comienzo: { required: true },
                e_desc: { required: true } 
            }

        });

    });

    //  Formulario de formación
    $("#submit_form").on("click", function(){

        $("#formacion").validate({

            rules: {
                f_nombre: { required: true, soloLetra: true },
                f_escuela: { required: true },
                f_localidad: { required: true, soloLetra: true },
                f_comienzo: { required: true },
                f_desc: { required: true } 
            }

        });

    });

    //  Formulario de idiomas
    $("#submit_lang").on("click", function(){

        $("#idioma").validate({

            rules: {
                i_name: { required: true, soloLetra: true },
                i_autoev: { required: true }
            }

        });

    });

     //  Formulario de envío de mensajes
     $("#submit_m").on("click", function(){

        $("#private").validate({

            rules: {
                m_contenido: { required: true }
            }

        });

    });

});

//  Recuerde, la contraseña distingue entre mayúsculas y minúsculas. Debe incluir al menos un número.