<?php session_start(); ?>
<div align="left" style="height:550px;">
    <div><span class="tituloEncabezado">Configuración:</span><span class="text-dark"> En esta sección podrá administrar la información de su cuenta.</span></div>
    <br>
    <?php if($_SESSION["tipoUsuario"] == 1){ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    Después de haber subido los archivos, haga click en el botón "Sincronizar" para para mantener la información de la base de datos actualizada. 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <?php } ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- Caja Usuarios -->
                <div class="card" style="width: 22rem;">
                    <span class="mx-auto fa fa-users text-warning" style="font-size:150px;"></span>
                    <div class="card-body">
                    <h5 class="card-title border-bottom">Usuarios</h5>
                    <p class="card-text">Edita aquí tu información personal y cambiar tu contraseña de acceso.</p>
                    <div align="left"><a id="editarInfo" style='color:#00F;' data-toggle="modal" data-target="#modalAfiliados" href="#modalAfiliados">Editar Información</a></div>
                    <div align="left"><a id="cambiarpass" style='color:#00F;' data-toggle="modal" data-target="#modalSetPass" href="#modalSetPass"> Cambiar Contraseña </a></div>
                    </div>
                </div>
            </div><!-- Fin column 1 -->
            <div class="col-md-4">
            <?php if($_SESSION["tipoUsuario"] == 1){  ?>
                <!-- Caja Adminitradores -->
                <div class="card mt-2" style="width: 24rem;">
                    <li class="mx-auto mt-2 fa fa-cog text-dark" style="font-size:150px;"></li>
                    <div class="card-body">
                        <h5 class="card-title border-bottom">Administración</h5>
                        <div align="left">
                            <a id="registrarafiliados" style='color:#00F;' data-toggle="modal" data-target="#modalRegistrarAfiliados" href="#modalRegistrarAfiliados"> Registrar Afiliados </a>
                        </div>
                        <div align="left">
                            <a id="buscar" style='color:#00F;' data-toggle="modal" data-target="#modalListAfiliados" href="#modalListAfiliados" >Listar Afiliados</a>
                        </div>
                        <h5 align="left" class="mt-4" style="width:74%;">Subir Archivos</h5>
                        <div id="subirArchivos">
                            <p>
                                <label>
                                <input type="radio" name="opcionesSubirArchivos" value="UploadHandler.php" id="opcionesSubirArchivos_0" checked="checked" />
                                Estado de Cuenta</label>
                                <br />
                                <!--<label>
                                <input type="radio" name="opcionesSubirArchivos" value="UploadHandler2.php" id="opcionesSubirArchivos_1" disabled="disabled" />
                                Movimientos Aportes</label>
                                <br />
                                <label>
                                <input type="radio" name="opcionesSubirArchivos" value="UploadHandler3.php" id="opcionesSubirArchivos_2" disabled="disabled" />
                                Movimientos Créditos</label>
                                <br />-->
                            </p>
                            <div align="center" style="border:1px #333; width:100%;">
                                <input type="button" class="btn btn-info" id="btsincronizar" name="btsincronizar" value="Sincronizar"  onclick="sincronizar()"/>
                            </div>
                            <div align="center" class="mt-2" style="width:80%;" id="contsinc"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div><!-- Fin column 2 -->
            <?php if($_SESSION["tipoUsuario"] == 1){  ?>
            <div class="col-md-4">
            <div>
                <div id="subir" style=""></div>
                <div style="vertical-align:top;">
                    <span class='post-labels'>
                    <b:if cond='data:post.labels'>
                        <data:postLabelsLabel/>
                        <b:loop values='data:post.labels' var='label'>
                        <a expr:href='data:label.url' rel='tag' style='font:Verdana, Geneva, sans-serif; font-size:14px; color:#FFF; font-weight:bold;'>Subir Archivos</a>
                        <!--<b:if cond='data:label.isLast != &quot;true&quot;'>,</b:if>-->
                        </b:loop>
                    </b:if>
                    </span>
                </div>
                </div>
            </div>
            <script language="JavaScript" type="text/javascript">
                vault = new dhtmlXVaultObject();
                vault.setImagePath("../dhtmlxVault/codebase/imgs/");
                
                vault.setServerHandlers("../dhtmlxVault/handlers/php_simple/UploadHandler.php", "../dhtmlxVault/handlers/php_simple/GetInfoHandler.php", "../dhtmlxVault/handlers/php_simple/GetIdHandler.php");
                
                vault.setFilesLimit(1);
                
                vault.create("subir");
                
                vault.onFileUploaded = function(file) {
                if(file.uploaded == true){
                    object_val = $('input[name=opcionesSubirArchivos]:checked').val();
        
                    idcheckeo = $('input[name=opcionesSubirArchivos]:checked').attr('id');
                    $("#"+idcheckeo).attr("checked",false);
                    $("#"+idcheckeo).attr({disabled:"disabled"});
                    
                    //hacer split
                    camp = idcheckeo.split("_");
                    campomas = parseInt(camp[1])+1;
                    
                    $("#opcionesSubirArchivos_"+campomas).attr({disabled:false});
                    $("#opcionesSubirArchivos_"+campomas).attr({checked:true});
                    
                    vault.removeAllItems();
                    vault.enableAddButton("enabled");
                    
                    if($("#opcionesSubirArchivos_1").attr("checked") == "checked"){
                    vault.setServerHandlers("../dhtmlxVault/handlers/php_simple/UploadHandler2.php", "../dhtmlxVault/handlers/php_simple/GetInfoHandler.php", "../dhtmlxVault/handlers/php_simple/GetIdHandler.php");
                    }else if($("#opcionesSubirArchivos_2").attr("checked") == "checked"){
                    vault.setServerHandlers("../dhtmlxVault/handlers/php_simple/UploadHandler3.php", "../dhtmlxVault/handlers/php_simple/GetInfoHandler.php", "../dhtmlxVault/handlers/php_simple/GetIdHandler.php");
                    }else{
                    vault.setServerHandlers("../dhtmlxVault/handlers/php_simple/UploadHandler.php", "../dhtmlxVault/handlers/php_simple/GetInfoHandler.php", "../dhtmlxVault/handlers/php_simple/GetIdHandler.php");	
                    }
                    
                    if($("#opcionesSubirArchivos_1").attr("checked") != "checked" && $("#opcionesSubirArchivos_2").attr("checked") != "checked" && $("#opcionesSubirArchivos_0").attr("checked") != "checked"){
                    jAlert("Se subieron correctamente todos los archivos. A continuación haga click en boton sincronizar.","Estado de Cuenta");
                    vault.enableAddButton();				
                    }
                    
                }
                };
                
            </script>
            </div><!-- Fin column 3 -->
            <?php } ?>
        </div><!-- Fin row -->
    </div><!-- Fin container-fluid -->

    <!-- Modal para formulario de afiliados para editar su información personal. -->
    <div class="modal fade bd-example-modal-lg" id="modalAfiliados" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php include "afiliados.php"; ?>
            </div>
        </div>
    </div>

    <!-- Modal para formulario para cambiar su contraseña. -->
    <div class="modal fade bd-example-modal-lg" id="modalSetPass" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php include "setPass.php"; ?>
            </div>
        </div>
    </div>

    <!-- Modal para listar afiliados. -->
    <div class="modal fade bd-example-modal-lg" id="modalListAfiliados" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php include "listarAfiliados.php"; ?>
            </div>
        </div>
    </div>
    
    <!-- Modal para registrar afiliados. -->
    <div class="modal fade bd-example-modal-lg" id="modalRegistrarAfiliados" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php include "registrarAfiliados.php"; ?>
            </div>
        </div>
    </div>
</div>