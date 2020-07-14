<?php
//CONEXION BD
$conex = mysqli_connect("127.0.0.1", "root", "", "campeonato");
if (!$conex) {
    echo "<p> Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    echo "</p>";
    exit;
}
//INICIALIZAR VARIABLES
$codEstadio = "";
$nombre = "";
$ciudad = "";
$direccion = "";
$capacidad = "";
$fecInaguracion = "";
$accion = "Agregar";
$eliminar = "Eliminar";

//AGREGAR ESTADIO
if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $stmt = $conex->prepare("INSERT INTO estadio (nombre, ciudad, direccion, capacidad, fecha_inaguracion ) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $nombre, $ciudad, $direccion, $capacidad, $fecInaguracion);
    $nombre = $_POST["nombre"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $capacidad = $_POST["capacidad"];
    $fecInaguracion = $_POST["fecInaguracion"];
    $stmt->execute();
    $stmt->close();
    $codEstadio = "";
    $nombre = "";
    $ciudad = "";
    $direccion = "";
    $capacidad = "";
    $fecInaguracion = "";
} 
//MODIFICAR ESTADIO
else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $stmt = $conex->prepare("UPDATE estadio SET nombre = ?, ciudad = ?, direccion = ?, capacidad = ?, fecha_inaguracion = ? WHERE cod_estadio = ?");
    $stmt->bind_param("sssisi", $nombre, $ciudad, $direccion, $capacidad, $fecInaguracion, $codEstadio);
    $nombre = $_POST["nombre"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $capacidad = $_POST["capacidad"];
    $fecInaguracion = $_POST["fecInaguracion"];
    $codEstadio = $_POST["codEstadio"];
    $stmt->execute();
    $stmt->close();
    $nombre = "";
    $ciudad = "";
    $direccion = "";
    $capacidad = "";
    $fecInaguracion = "";
    $codEstadio = "";
} 
else if (isset($_GET["update"])) {
    $result = $conex->query("SELECT * FROM estadio WHERE cod_estadio=" . $_GET["update"]);
    if ($result->num_rows > 0) {
        $row1 = $result->fetch_assoc();
        $codEstadio = $row1["cod_estadio"];
        $nombre = $row1["nombre"];
        $ciudad = $row1["ciudad"];
        $direccion = $row1["direccion"];
        $capacidad = $row1["capacidad"];
        $fecInaguracion = $row1["fecha_inaguracion"];
        $accion = "Modificar";
    }
} 
//ELIMINAR ESTADIO
else if (isset($_GET["delete"])) {
    $stmt = $conex->prepare("DELETE FROM estadio WHERE cod_estadio = ".$_GET["delete"]);
    $stmt->execute();
    $stmt->close();
    $codEstadio = "";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16"
            href="./assets/images/favicon.png">
        <title>Xtreme BD PHP</title>
        <!-- Custom CSS -->
        <link href="./assets/libs/chartist/dist/chartist.min.css"
            rel="stylesheet">
        <!-- Custom CSS -->
        <link href="./dist/css/style.min.css" rel="stylesheet">
    </head>

    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5"
            data-sidebartype="full" data-sidebar-position="absolute"
            data-header-position="absolute" data-boxed-layout="full">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <header class="topbar" data-navbarbg="skin5">
                <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                    <div class="navbar-header" data-logobg="skin5">
                        <!-- ============================================================== -->
                        <!-- Logo -->
                        <!-- ============================================================== -->
                        <a class="navbar-brand" href="index.html">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="./assets/images/logo-icon.png"
                                    alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="./assets/images/logo-light-icon.png"
                                    alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="./assets/images/logo-text.png"
                                    alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="./assets/images/logo-light-text.png"
                                    class="light-logo" alt="homepage" />
                            </span>
                        </a>
                        <!-- ============================================================== -->
                        <!-- End Logo -->
                        <!-- ============================================================== -->
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                </nav>
            </header>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <aside class="left-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item"> <a class="sidebar-link
                                    waves-effect waves-dark sidebar-link"
                                    href="index.html" aria-expanded="false"><i
                                        class="mdi mdi-view-dashboard"></i><span
                                        class="hide-menu">Gestión Estadios</span></a></li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <img src="./assets/images/estadio.png"
                                    alt="homepage" class="dark-logo" />
                                    <div>
                                        <h2 class="card-title"><p>&nbsp;&nbsp</p>Listado de Estadios</h2>
                                    </div>
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">Codigo</th>
                                            <th class="border-top-0">Nombre</th>
                                            <th class="border-top-0">Ciudad</th>
                                            <th class="border-top-0">Dirección</th>
                                            <th class="border-top-0">Capacidad</th>
                                            <th class="border-top-0">Fecha Inaguración</th>
                                            <th class="border-top-0">Opciones</th>
                                        </tr>
                                        <?php
                                        /*DATOS DE LA TABLA */
                                        $result = $conex->query("SELECT * FROM estadio");
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex
                                                    align-items-center">
                                                    <div class="m-r-10"><a
                                                            class="btn
                                                            btn-circle btn-info
                                                            text-white"><?php echo $row["cod_estadio"]; ?></a></div>
                                                </div>
                                            </td>
                                            <td><?php echo $row["nombre"]; ?></td>
                                            <td><?php echo $row["ciudad"]; ?></td>
                                            <td><?php echo $row["direccion"]; ?></td>
                                            <td><?php echo $row["capacidad"]; ?></td>
                                            <td><?php echo $row["fecha_inaguracion"]; ?></td>
                                            <td>
                                                <a href="index.php?update=<?php echo $row["cod_estadio"]; ?>" title="Editar datos" name="modificar" class="btn btn-primary btn-sm"><span class="far fa-edit fa-lg" aria-hidden="true"></span></a>
								                <a href="index.php?delete='<?php echo $row["cod_estadio"]?>'" title="Eliminar" name="eliminar" class="btn btn-danger btn-sm"><span class="far fa-trash-alt fa-lg" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }else { ?>
                                            <tr>
                                                <td colspan="5">NO HAY DATOS</td>;
                                            </tr>
                                            <?php } ?>        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Table -->
                
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <form name="forma" class="form-horizontal form-material" method="post" action="index.php">
                                <input type="hidden" name="codEstadio" value="<?php echo $codEstadio ?>">
                                <div class="form-group">
                                    <label class="col-md-12">Nombre</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Anfield Stadium" class="form-control
                                            form-control-line" name="nombre"
                                            id="nombre" value="<?php echo $nombre ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email"
                                        class="col-md-12">Ciudad</label>
                                    <div class="col-md-12">
                                        <input type="text"
                                            placeholder="Liverpool"
                                            class="form-control
                                            form-control-line" name="ciudad"
                                            id="ciudad" value="<?php echo $ciudad ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Dirección</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Anfield Road"
                                            class="form-control
                                            form-control-line" name="direccion"
                                            id="direccion" value="<?php echo $direccion ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6">Capacidad</label>
                                    <label class="col-sm-4">Fecha de Inaguración</label>
                                    <div class="input-group col-md-12">
                                        <input type="number" placeholder="54074"
                                            class="form-control
                                            form-control-line col-sm-6"
                                            name="capacidad" id="capacidad"
                                            min="1" max="100000" value="<?php echo $capacidad ?>" required>
                                        <div class="input-group-prepend
                                            cold-md-4">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="date"
                                            class="form-control
                                            form-control-line col-sm-6"
                                            name="fecInaguracion"
                                            id="fecInaguracion" value="<?php echo $fecInaguracion ?>" min="1860-07-10" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input class="btn btn-success
                                            btn-block" type="submit" name="accion" value="<?php echo $accion ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>

        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="./assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="./assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="./dist/js/app-style-switcher.js"></script>
        <!--Wave Effects -->
        <script src="./dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="./dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="./dist/js/custom.js"></script>
        <!--This page JavaScript -->
        <!--chartis chart-->
        <script src="./assets/libs/chartist/dist/chartist.min.js"></script>
        <script
            src="./assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
        <script src="./dist/js/pages/dashboards/dashboard1.js"></script>
    </body>

    <script>
    function eliminacionEstadio() {
        document.getElementById("forma").submit();
    }
    </script>
</html>