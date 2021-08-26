<!DOCTYPE html>
<html lang="es">
<head>
    <title>TiajiTico</title>
    <?php include './plantilla/link.php'; ?>
</head>

<body id="container-page-index">
    <?php include './plantilla/navbar.php'; ?>
    
    <section id="slider-store" class="carousel slide" data-ride="carousel" style="padding: 0;">

        <!-- Indicators 
        <ol class="carousel-indicators">
            <li data-target="#slider-store" data-slide-to="0" class="active"></li>
            <li data-target="#slider-store" data-slide-to="1"></li>
            <li data-target="#slider-store" data-slide-to="2"></li>
        </ol>
        -->
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">

            <div class="item active">
                <video id="crvideo">
                    <source src="video/CostaRican.mp4" type="video/mp4">
                    <source src="Video/CostaRican.mp4" type="video/ogg">
                </video>
                <form action="./search.php" method="GET">
                <div class="field" id="searchform">
                    <input type="text" id="searchterm" placeholder="A dónde quieres ir?" />
                    <button type="submit" id="search">Buscar!</button>
                </div>
                </form>  
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="#1ABC9C" fill-opacity="1"
                        d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,245.3C672,256,768,256,864,234.7C960,213,1056,171,1152,165.3C1248,160,1344,192,1392,208L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>


        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#slider-store" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#slider-store" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </section>
    

    <section id="new-prod-index">    
         <div class="container">
            <div class="page-header">
                <h1>Reservas <small> agregados</small></h1>
            </div>
            <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading text-center"><h4>Lista Reservaciones</h4></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                              <th class="text-center"></th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Cantidad</th> 
                                <th class="text-center">Nombre Completo</th>
                                <th class="text-center">Cedula</th>
                                <th class="text-center">Idioma</th>
                                <th class="text-center">Destino</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center">Telefono</th>
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

                                $destinos=ejecutarSQL::consultar("SELECT * FROM todasReservas");
                                oci_execute($destinos);
                                $totalregistros = ejecutarSQL::consultar("SELECT count(*) FROM todasReservas");
                                oci_execute($destinos);
                                $totalregistros = oci_num_rows($totalregistros);
                                
                                $numeropaginas = 1;

                                $cr=$inicio+1;
                                
                                while($row=oci_fetch_array($destinos, OCI_ASSOC)){
                            ?>
                            <tr>
                            <td class="text-center"><?php echo $cr; ?></td>
                            <td class="text-center"><?php echo $row['FECHA']; ?></td>
                            <td class="text-center"><?php echo $row['CANTIDAD']; ?></td>
                            <td class="text-center"><?php echo $row['NOMBRE']." ".$row['APELLIDO1']." ".$row['APELLIDO2']; ?></td>
                            <td class="text-center"><?php echo $row['CEDULA']; ?></td>
                            <?php $idioma = $row['ID_IDIOMA'];
                            if ($idioma == 1) {?>
                                <td class="text-center">Espa&ntilde;ol</td><?php
                            } else {?>
                                <td class="text-center">Ingles</td><?php
                            }
                             ?>
                            <td class="text-center"><?php echo $row['DES_ACTIVIDAD']; ?></td>
                            <td class="text-center"><?php echo $row['DES_EMAIL']; ?></td>
                            <td class="text-center"><?php echo $row['DES_TELEFONO']; ?></td>
                            <td class="text-center"><?php echo $row['DES_PROVINCIA']; ?></td>
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
    </section>
    <section id="reg-info-index">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 text-center">
                   <article style="margin-top:5%;">
                        <p><i class="fa fa-users fa-4x"></i></p>
                        <h3>Registrate</h3>
                        <p>Registrate como cliente de <span class="tittles-pages-logo">ViajiTico</span> en un sencillo formulario para poder completar tus pedidos</p>
                        <p><a href="registration.php" class="btn btn-info btn-raised btn-block">Registrarse</a></p>   
                   </article>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <img src="assets/img/tv.png" alt="Smart-TV" class="img-responsive" style="width: 70%; display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </section>

    <?php include './plantilla/footer.php'; ?>
</body>
</html>