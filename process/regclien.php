<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$pCedula = consultasSQL::clean_string($_POST['cliennit']);
$pnombre = consultasSQL::clean_string($_POST['clienfullname']);
$papellido1 = consultasSQL::clean_string($_POST['clienlastname']);
$papellido2 = consultasSQL::clean_string($_POST['clienlastname2']);
$pTelefono = consultasSQL::clean_string($_POST['clienphone']);
$pEmail = consultasSQL::clean_string($_POST['clienemail']);
$pdestino = consultasSQL::clean_string($_POST['cliendestino']);
$pIdioma = consultasSQL::clean_string($_POST['idioma']);
$pfecha = consultasSQL::clean_string($_POST['fecha']);
$pCantidad = consultasSQL::clean_string($_POST['cantidad']);
$pComentario = consultasSQL::clean_string($_POST['comentario']);

if (!$pCedula == "" && !$pnombre == "" && !$papellido1 == "" && !$papellido2 == "" && !$pTelefono == "" && !$pEmail == "" && !$pdestino == "" && !$pIdioma == "" && !$pfecha == "" && !$pCantidad == "" && !$pComentario == "") {
  $conexion = ejecutarSQL::conectar();
  $INSERTAR = oci_parse($conexion, "BEGIN pack_insert.p_insert_reserva (to_date(:pFecha, 'YYYY-MM-DD'), TO_NUMBER(:pDestino), :pNombre, :pApellido1, :pApellido2, :pCedula, TO_NUMBER(:pIdioma), :pTelefono, :pEmail, TO_NUMBER(:pCantidad), :pComentario); END;");

  $fecha = $pfecha;
  $destino = intval($pdestino);
  $nombre = $pnombre;
  $apellido1 = $papellido1;
  $apellido2 = $papellido2;
  $cedula = $pCedula;
  $idioma = intval($pIdioma);
  $telefono = $pTelefono;
  $email = $pEmail;
  $cantidad = intval($pCantidad);
  $comentario = $pComentario;

  oci_bind_by_name($INSERTAR, ':pFecha', $fecha);
  oci_bind_by_name($INSERTAR, ':pDestino', $destino);
  oci_bind_by_name($INSERTAR, ':pNombre', $nombre);
  oci_bind_by_name($INSERTAR, ':pApellido1', $apellido1);
  oci_bind_by_name($INSERTAR, ':pApellido2', $apellido2);
  oci_bind_by_name($INSERTAR, ':pCedula', $cedula);
  oci_bind_by_name($INSERTAR, ':pIdioma', $idioma);
  oci_bind_by_name($INSERTAR, ':pTelefono', $telefono);
  oci_bind_by_name($INSERTAR, ':pEmail', $email);
  oci_bind_by_name($INSERTAR, ':pCantidad', $cantidad);
  oci_bind_by_name($INSERTAR, ':pComentario', $comentario);

  $resultado = oci_execute($INSERTAR); //commit
  oci_commit($conexion);

  if ($resultado) {
    echo '<script>
                    swal.fire({
                      title: "Registro completado",
                      text: "El registro se completó con éxito, ya puedes iniciar sesión en el sistema",
                      type: "success",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Aceptar",
                      cancelButtonText: "Cancelar",
                      closeOnConfirm: false,
                      closeOnCancel: false
                      },
                      function(isConfirm) {
                      if (isConfirm) {
                        location.reload();
                      } else {
                        location.reload();
                      }
                    });
                </script>';
  } else {
    echo '<p>Error insercion de datos!</p>';
  }

  oci_free_statement($INSERTAR); //cerrar sesion

  oci_close($conexion); //cerrar conexion

  //fin insersion preparada
} else {
  echo '<script>swal("ERROR", "Los campos no pueden estar vacíos", "error");</script>';
}
