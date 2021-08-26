$(document).ready(function () {

    $("#btEnviar").click(function () {
        ingresaReserva($("#cliennit").val(), $("#clienfullname").val(), $("#clienlastname").val(), 
        $("#clienlastname2").val(),$("#clienphone").val(),$("#clienemail").val(),$("#cliendestino").val(),
        $("#input[name='idioma']:checked").val(),$("#fecha").val(),$("#cantidad").val(),$("#comentario").val());
    });

    // $("#btRestablecer").click(function () {
    //     LimpiaCampos();
    // });
    

});

function ingresaReserva(pCedula, pnombre, papellido1, papellido2, pTelefono,pEmail,pdestino,pIdioma,pfecha,pCantidad,pComentario) {
    try {
        $.ajax(
            {
                data: {
                    clien_nit: pCedula,
                    clien_fullname: pnombre,
                    clien_lastname: papellido1,
                    clien_lastname2: papellido2,
                    clien_phone: pTelefono,
                    clien_email: pEmail,
                    clien_destino: pdestino,
                    idioma: pIdioma,
                    fecha: pfecha,
                    cantidad: pCantidad,
                    comentario: pComentario,                  
                },
                url: 'regClien.php',
                type: 'POST',
                dataType: 'json',
                beforeSend: function () 
                {
                   $("#pnlInfo").fadeTo("slow");
                    $("#pnlMensaje").fadeTo("slow");
                },
                success: function (r) {
                    InsercionTutoriaExitosa(r);
                },
                error: function (r) {
                    InsercionTutoriaFallida(r);
                }
            });
             swal.fire({
                title: "¿Estás seguro?",   
                text: "Quieres realizar la operación solicitada, una vez realizada la operación no se podrá revertir",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#16a085",   
                confirmButtonText: "Si, realizar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                animation: "slide-from-top"
            }, function(){
                $.ajax({
                    xhr: function(){
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.content-send-form').html('<p class="text-center" style="padding-top: 10px;">Procesando... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar" style="width: '+percentComplete+'%"></div></div>');
                          }
                        }, false);
                        return xhr;
                    },
                    type: metodo,
                    url: formAction,
                    data: formdata ? formdata : form.serialize(),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".ResbeforeSend").html(StatusInfo);
                    },
                    error: function() {
                        $(".ResbeforeSend").html("Ha ocurrido un error en el sistema");
                    },
                    success: function (data) {
                        $(".ResbeforeSend").html(data);
                    }
                });
                return false;
            });
    } catch (err) {
        alert(err);
    }
}

function InsercionTutoriaExitosa(TextoJSON) {

    $("#pnlInfo").dialog();
    $("#blInfo").html('<p>' + TextoJSON + '</p>');
    LimpiaCampos();
}

function LimpiaCampos() {
    $("#clien_nit").val("");
    $("#clien_fullname").val("");
    $("#clien_lastname").val(""); 
    $("#clien_lastname2").val("");
    $("#clien_phone").val("");
    $("#clien_email").val("");
    $("#clien_destino").val("");
    $("#input[name='idioma'][value='2021']").prop("checked",true);
    $("#fecha").val("");
    $("#cantidad").val("");
    $("#comentario").val("");
    //$('input[name="hora"]').attr('checked', false);
}//Fin LimpiaCampos ================================================

function InsercionTutoriaFallida(TextoJSON) {
    $("#pnlMensaje").dialog();
    $("#pnlMensaje").html('<p>Ocurrio un error en el servidor ..</p>' + TextoJSON.responseText);
}