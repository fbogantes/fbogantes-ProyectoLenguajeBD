<?php
include './library/configServer.php';
include './library/consulSQL.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>destinos</title>
    <?php include './plantilla/link.php'; ?>
</head>

<body id="container-page-product">
    <?php include './plantilla/navbar.php'; ?>
    <section id="infoproduct">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>DETALLE DE destino <small class="tittles-pages-logo">viajitico</small></h1>
                </div>
                <?php 
                    $Codigodestino=consultasSQL::clean_string($_GET['CodigoProd']);
                    $destinoinfo=  ejecutarSQL::consultar("SELECT destino.CodigoProd,destino.NombreProd,destino.CodigoCat,categoria.Nombre,destino.Precio,destino.Descuento,destino.Stock,destino.Imagen FROM categoria INNER JOIN destino ON destino.CodigoCat=categoria.CodigoCat  WHERE CodigoProd='".$Codigodestino."'");
                    while($fila=oci_fetch_array($destinoinfo, oci_ASSOC)){
                        echo '
                            <div class="col-xs-12 col-sm-6">
                                <h3 class="text-center">Información de destino</h3>
                                <br><br>
                                <h4><strong>Nombre: </strong>'.$fila['NombreProd'].'</h4><br>
                                <h4><strong>Precio: </strong>$'.number_format(($fila['Precio']-($fila['Precio']*($fila['Descuento']/100))), 2, '.', '').'</h4><br>
                                <h4><strong>Cantidad: </strong>'.$fila['Stock'].'</h4><br>
                                <h4><strong>Categoria: </strong>'.$fila['Nombre'].'</h4>';
                                if($fila['Stock']>=1){
                                    if($_SESSION['nombreAdmin']!="" || $_SESSION['nombreUser']!=""){
                                        echo '<form action="process/carrito.php" method="POST" class="FormCatElec" data-form="">
                                            <input type="hidden" value="'.$fila['CodigoProd'].'" name="codigo">
                                            <label class="text-center"><small>Agrega la cantidad de destinos que añadiras al carrito de compras (Maximo '.$fila['Stock'].' destinos)</small></label>
                                            <div class="form-group">
                                                <input type="number" class="form-control" value="1" min="1" max="'.$fila['Stock'].'" name="cantidad">
                                            </div>
                                            <button class="btn btn-lg btn-raised btn-success btn-block"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; Añadir al carrito</button>
                                        </form>
                                        <div class="ResForm"></div>';
                                    }else{
                                        echo '<p class="text-center"><small>Para agregar destinos al carrito de compras debes iniciar sesion</small></p><br>';
                                        echo '<button class="btn btn-lg btn-raised btn-info btn-block" data-toggle="modal" data-target=".modal-login"><i class="fa fa-user"></i>&nbsp;&nbsp; Iniciar sesion</button>';
                                    }
                                }else{
                                    echo '<p class="text-center text-danger lead">No hay existencias de este destino</p><br>';
                                }
                                if($fila['Imagen']!="" && is_file("./assets/img-products/".$fila['Imagen'])){ 
                                    $imagenFile="./assets/img-products/".$fila['Imagen']; 
                                }else{ 
                                    $imagenFile="./assets/img-products/default.png"; 
                                }
                                echo '<br>
                                <a href="product.php" class="btn btn-lg btn-primary btn-raised btn-block"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;Regresar a la tienda</a>
                            </div>


                            <div class="col-xs-12 col-sm-6">
                                <br><br><br>
                                <img class="img-responsive" src="'.$imagenFile.'">
                            </div>';
                    }
                ?>
            </div>
        </div>
    </section>

    <?php include './plantilla/footer.php'; ?>

</body>

</html>