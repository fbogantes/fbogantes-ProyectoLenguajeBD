<!DOCTYPE html>
<html lang="es">
<head>
    <title>Destino</title>
    <?php include './plantilla/link.php'; ?>
</head>
<body id="container-page-product">
    <?php include './plantilla/navbar.php'; ?>
    <section id="form-registration">
<div class="container">
  <div class="row">
        <div class="col-xs-12">
            <br><br>
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

                                $destinos=ejecutarSQL::consultar("SELECT * FROM DESTINO_VIEW");
                                oci_execute($destinos);
                                $totalregistros = ejecutarSQL::consultar("SELECT count(*) FROM DESTINO");
                                oci_execute($destinos);
                                $totalregistros = oci_num_rows($totalregistros);
                                
                                $numeropaginas = 1;

                                $cr=$inicio+1;
                                
                                while($row=oci_fetch_array($destinos, OCI_ASSOC)){
                            ?>
                            <tr>
                            <td class="text-center"><?php echo $cr; ?></td>
                            <td class="text-center"><?php echo $row['DES_ACTIVIDAD']; ?></td>
                            <td class="text-center"><?php echo $row['DES_CANTON']; ?></td>
                            <td class="text-center"><?php echo $row['DES_PROVINCIA']; ?></td>
                            <td class="text-center"><?php echo $row['DES_PAIS']; ?></td>
                            <td class="text-center">
                                <a href="#!" class="btn btn-raised btn-xs btn-success btn-block btn-up-row" data-code="<?php echo $row["ID_DESTINO"]; ?>">Actualizar</a>
                            </td>
                            <td class="text-center">
                              <form action="process/delPedido.php" method="POST" class="FormCatElec" data-form="delete">
                                <input type="hidden" name="num-pedido" value="<?php echo $row["ID_DESTINO"]; ?>">
                                <button type="submit" class="btn btn-raised btn-xs btn-danger">Eliminar</button>  
                              </form>
                            </td>
                            </tr>
                            <?php
                              $cr++;
                              }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if($numeropaginas>=1): ?>
                <div class="text-center">
                  <ul class="pagination">
                    <?php if($pagina == 1): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="configAdmin.php?view=row&pag=<?php echo $pagina-1; ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php
                        for($i=1; $i <= $numeropaginas; $i++ ){
                            if($pagina == $i){
                                echo '<li class="active"><a href="configAdmin.php?view=row&pag='.$i.'">'.$i.'</a></li>';
                            }else{
                                echo '<li><a href="configAdmin.php?view=row&pag='.$i.'">'.$i.'</a></li>';
                            }
                        }
                    ?>
                    

                    <?php if($pagina == $numeropaginas): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="configAdmin.php?view=row&pag=<?php echo $pagina+1; ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                  </ul>
                </div>
                <?php endif; ?>
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
<script>
    $(document).ready(function(){
        $('.btn-up-row').on('click', function(e){
            e.preventDefault();
            var code=$(this).attr('data-code');
            $.ajax({
                url:'./process/checkOrder.php',
                type: 'POST',
                data: 'code='+code,
                success:function(data){
                    $('#OrderSelect').html(data);
                    $('#modal-row').modal({
                        show: true,
                        backdrop: "static"
                    });  
                }
            });
            return false;

        });
    });
</script>
    <?php include './plantilla/footer.php'; ?>
</body>
</html>