<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/css/bootstrap-table.min.css">

        <link rel="stylesheet" href="css/styles-general.css">

        <script src="vendor/js/jquery-3.2.1.min.js"></script>

        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <script src="vendor/js/bootstrap-table.min.js"></script>
        <script src="vendor/js/bootstrap-table-es-AR.min.js"></script>

        <script src="vendor/js/bootstrap-table-print.js"></script>
        <script src="vendor/js/bootstrap-table-export.js"></script>
        <script src="vendor/js/tableExport.js"></script>
        <script src="vendor/js/jspdf.min.js"></script>
        <script src="vendor/js/jspdf.plugin.autotable.js"></script>


        <script src="js/general_api.js"></script>

        <title><?= $page_title ?></title>
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                  <a href="home.php" class="navbar-brand">I.S.F.D. PAG</a>
                  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Altas/Bajas<span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a href="profesores.php">Profesores</a></li>
                                <!-- <li class="divider"></li> -->
                                <li><a href="../cerulean/">Materias</a></li>
                                <li><a href="../cosmo/">Carreras</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Mantenimiento<span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a href="../default/">Planes de estudio</a></li>
                                <li><a href="../cerulean/">Duración materias</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Administrar<span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a href="../default/">Usuarios</a></li>
                                <li><a href="../cerulean/">Grupos y permisos</a></li>
                            </ul>
                        </li>
                        <!--
                        <li>
                          <a href="../help/">Help</a>
                        </li>
                        -->
                        <!--
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Superhero <span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="download">
                                <li><a href="http://jsfiddle.net/bootswatch/9n4nxnqy/">Open Sandbox</a></li>
                                <li class="divider"></li>
                                <li><a href="./bootstrap.min.css">bootstrap.min.css</a></li>
                                <li><a href="./bootstrap.css">bootstrap.css</a></li>
                                <li class="divider"></li>
                                <li><a href="./variables.less">variables.less</a></li>
                                <li><a href="./bootswatch.less">bootswatch.less</a></li>
                                <li class="divider"></li>
                                <li><a href="./_variables.scss">_variables.scss</a></li>
                                <li><a href="./_bootswatch.scss">_bootswatch.scss</a></li>
                            </ul>
                        </li>
                        -->
                    </ul>

                    <!--
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
                        <li><a href="https://wrapbootstrap.com/?ref=bsw" target="_blank">WrapBootstrap</a></li>
                    </ul>
                    -->

            </div>
          </div>
        </div>

        <div class="container">
