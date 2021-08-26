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
    <section id="viajitico">
       <br>
        <div class="container">
            <div class="page-header">
              <h1>Busqueda de destinos <small class="tittles-pages-logo">ViajiTico</small></h1>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-8">
                  <form action="./search.php" method="GET">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        <input type="text" id="addon1" class="form-control" name="term" required="" title="Escriba nombre o Provincia del destino">
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-raised" type="submit">Buscar</button>
                        </span>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php
              $search=consultasSQL::clean_string($_GET['term']);
              if(isset($search) && $search!=""){
            ?>
              <div class="container-fluid">
                <div class="row">
                <div class="panel panel-info">
                <div class="panel-heading text-center"><h4>Destinos de la Página</h4></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                              <th class="text-center">ID</th>
                                <th class="text-center">Destino</th>
                                <th class="text-center">Canton</th> 
                                <th class="text-center">Provincia</th>
                                <th class="text-center">Pais</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php
                            include './library/configServer.php';
                            include './library/consulSQL.php';

                                $oci = ejecutarSQL::conectar();

                                $pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
                                $regpagina = 30;
                                $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                                $destinos=ejecutarSQL::consultar("SELECT * FROM DESTINO_VIEW where DES_ACTIVIDAD LIKE '%':term'%' OR Canton LIKE '%':term'%' OR Provincia LIKE '%':term'%'");
                                oci_bind_by_name($destinos, ':term', $search);
                                oci_execute($destinos);

                                $cr=$inicio+1;
                                
                                while($row=oci_fetch_array($destinos, OCI_ASSOC)){
                            ?>
                            <tr>
                            <td class="text-center"><?php echo $cr; ?></td>
                            <td class="text-center"><?php echo $row['DES_ACTIVIDAD']; ?></td>
                            <td class="text-center"><?php echo $row['DES_CANTON']; ?></td>
                            <td class="text-center"><?php echo $row['DES_PROVINCIA']; ?></td>
                            <td class="text-center"><?php echo $row['DES_PAIS']; ?></td>
                            <?php
                              $cr++;
                              }
                            ?>
                        </tbody>
                    </table>
                    </div>

                <?php 
              } ?>
            </div>
        </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-row" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content" style="padding: 15px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h5 class="modal-title text-center text-primary" id="myModalLabel">Actualizar estado del pedido</h5>
        </div>
        <form action="./process/updatePedido.php" method="POST" class="FormCatElec" data-form="update">
            <div id="OrderSelect"></div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success btn-raised btn-sm">Actualizar</button>
              <button type="button" class="btn btn-danger btn-raised btn-sm" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
      </div>
  </div>
</div>
    </section>
    <?php  include './plantilla/footer.php'; ?>
</body>
</html>