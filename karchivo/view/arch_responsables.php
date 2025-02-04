<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <title>Plataforma de Gestión Empresarial</title>

    <?php
    session_start();

    require('Head.php')
    ?>

    <script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

    <script type="text/javascript" src="../js/inv_bodega.js"></script>

</head>

<body>

    <!-- ------------------------------------------------------ -->

    <!-- ------------------------------------------------------ -->
    <div class="col-md-12" role="banner">
        <div id="MHeader"></div>
    </div>

    <div id="mySidenav" class="sidenav">
        <div class="panel panel-primary">
            <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
            <div class="panel-body">
                <div id="ViewModulo"></div>
            </div>
        </div>
    </div>

    <!-- Content Here -->
    <div class="col-md-12">

        <!-- Content Here -->
        <ul id="mytabs" class="nav nav-tabs">

            <li class="active"><a href="#tab1" data-toggle="tab"></span>
                    <span class="glyphicon glyphicon-th-list"></span> <b>DEFINICION DE BODEGAS </b> </a>
            </li>

            <li><a href="#tab2" data-toggle="tab">
                    <span class="glyphicon glyphicon-link"></span> Agregar Bodegas</a>
            </li>

            <li><a href="#tab3" data-toggle="tab">
                    <span class="glyphicon glyphicon-cog"></span> Generar Carga Inicial Bodegas</a>
            </li>

        </ul>

        <!-- ------------------------------------------------------ -->
        <!-- Tab panes -->
        <!-- ------------------------------------------------------ -->
        <div class="tab-content">

            <!-- ------------------------------------------------------ -->
            <!-- Tab 1 -->
            <!-- ------------------------------------------------------ -->

            <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

                <div class="panel panel-default">
                    <div class="panel-body">




                        <div class="col-md-12">
                            <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
                                <thead bgcolor=#F5F5F5>
                                    <tr>
                                        <th width="5%">Codigo</th>
                                        <th width="15%">Nombre</th>
                                        <th width="10%">Identificación</th>
                                        <th width="20%">Responsable</th>
                                        <th width="20%">Ubicacion</th>
                                        <th width="10%">Activo</th>
                                        <th width="10%">Telefono</th>
                                        <th width="10%">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ------------------------------------------------------ -->
            <!-- Tab 2 -->
            <!-- ------------------------------------------------------ -->

            <div class="tab-pane fade in" id="tab2" style="padding-top: 3px">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div id="ViewForm"> </div>

                    </div>
                </div>
            </div>
            <!-- ------------------------------------------------------ -->
            <!-- Tab 2 -->
            <!-- ------------------------------------------------------ -->
            <div class="tab-pane fade in" id="tab3" style="padding-top: 3px">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="col-md-12">
                            <div class="col-md-7">
                                <h4>Generar Traslado de saldos al periodo</h4>
                                <div id="ViewFormInicia"> </div>
                            </div>
                            <div class="col-md-5">
                                <div id="ViewFormIniciaCuenta"> </div>
                                <div id="resultado_fin"> </div>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <button type="button" onClick="GenerarProceso()" class="btn btn-danger">Generar proceso</button>

                            <button type="button" onClick="BodegaSaldoAnual()" class="btn btn-info">Visualizar Datos iniciales</button>


                            <button id="printButton" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>

                        </div>

                        <div class="col-md-12" id="ViewForm1" style='padding-bottom: 10px;padding-top: 10px'>

                            <div id="resultado_detalle"> </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Page Footer-->
    <div id="FormPie"></div>
    </div>
</body>

</html>