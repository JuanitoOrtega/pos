<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Crear venta
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear venta</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">

      <!--============================================
      EL FORMULARIO
      =============================================-->

      <div class="col-lg-5 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">

          </div>
          <form role="form" method="post" class="formularioVenta">
            <div class="box-body">
                <div class="box">

                  <?php

                    $item = "id";
                    $valor = $_GET["idVenta"];
                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $venta["id_vendedor"];
                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta["id_cliente"];
                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    $porcentajeImpuesto = $venta["impuesto"] * 100 / $venta["neto"];

                  ?>

                  <!--============================================
                  ENTRADA DEL VENDEDOR
                  =============================================-->

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor["nombre"]; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"]; ?>">
                    </div>
                  </div>

                  <!--============================================
                  ENTRADA DEL CÓDIGO
                  =============================================-->

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $venta["codigo"]; ?>" readonly>
                    </div>
                  </div>

                  <!--============================================
                  ENTRADA DEL CLIENTE
                  =============================================-->

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" style="height: 36px;" required>
                        <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["nombre"]; ?></option>

                        <?php
                          $item = null;
                          $valor = null;
                          $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);
                          foreach ($categorias as $key => $value) {
                            echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                          }

                        ?>

                      </select>
                      <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>
                    </div>
                  </div>

                  <!--============================================
                  ENTRADA PARA AGREGAR PRODUCTO
                  =============================================-->

                  <div class="form-group row nuevoProducto">

                  <?php

                    $listaProducto = json_decode($venta["productos"], true);

                    foreach ($listaProducto as $key => $value) {

                      $item = "id";
                      $valor = $value["id"];
                      $orden = "id";
                      
                      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                      $stockAntiguo = $respuesta["stock"] + $value["cantidad"];

                      echo '<div class="row" style="padding:5px 15px">
                            <div class="col-xs-6" style="padding-right:0px">
                              <div class="input-group">
                                <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>
                                <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>
                              </div>
                            </div>
                            <div class="col-xs-3">
                              <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>
                            </div>

                            <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_venta"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
                              </div>
                            </div>
                            </div>';
                    }

                  ?>

                  </div>

                  <input type="hidden" id="listaProductos" name="listaProductos">

                  <!--============================================
                  BOTÓN PARA AGREGAR PRODUCTOS
                  =============================================-->

                  <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                  <hr>

                  <!--============================================
                  ENTRADA IMPUESTO Y TOTAL
                  =============================================-->

                  <div class="row">
                    <div class="col-xs-8 pull-right">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Impuestos</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="width:50%">
                              <div class="input-group">
                                <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php echo $porcentajeImpuesto; ?>" required>
                                <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $venta["impuesto"]; ?>" required>
                                <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $venta["neto"]; ?>" required>
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                              </div>
                            </td>
                            <td style="width:50%">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $venta["neto"]; ?>" value="<?php echo $venta["total"]; ?>" placeholder="00000" readonly required>
                                <input type="hidden" name="totalVenta" value="<?php echo $venta["total"]; ?>" id="totalVenta">
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <hr>

                  <!--============================================
                  MÉTODO DE PAGO
                  =============================================-->

                  <div class="form-group row">
                    <div class="col-xs-6" style="padding-right:0px">
                      <div class="input-group">
                        <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                          <option value="">Seleccione forma de pago</option>
                          <option value="Efectivo">Efectivo</option>
                          <option value="TC">Tarjeta de Crédito</option>
                          <option value="TD">Tarjeta de Débito</option>
                        </select>
                      </div>
                    </div>

                    <div class="cajasMetodoPago"></div>
                    <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                  </div>
                  <br>
                </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>
            </div>
          </form>

          <?php
            $editarVenta = new ControladorVentas();
            $editarVenta->ctrEditarVenta();
          ?>

        </div>
      </div>

      <!--============================================
      LA TABLA DE PRODUCTOS
      =============================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">
          <div class="box-header width-border">

          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablaVentas" width="100%">
              <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripción</th>
                  <th>Stock</th>
                  <th>Precio</th>
                  <th>Acciones</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!--============================================
MODAL AGREGAR CLIENTE
=============================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--============================================
        ENCABEZADO DEL MODAL
        =============================================-->

        <div class="modal-header" style="background: #3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar cliente</h4>
        </div>

        <!--============================================
        CUERPO DEL MODAL
        =============================================-->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-o"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>
              </div>
            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>
              </div>
            </div>

            <!-- ENTRADA PARA EL CORREO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar correo" required>
              </div>
            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-99999'" data-mask required>
              </div>
            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>
              </div>
            </div>

            <!-- ENTRADA PARA FECHA DE NACIMIENTO -->
            <div class="form-group">
              <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-lg datepicker" name="nuevaFechaNacimiento" placeholder="Ingresar fecha de nacimiento" required>
                <!-- <input type="date" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha de nacimiento" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required> -->
              </div>
            </div>

          </div>
        </div>

        <!--============================================
        FOOTER DEL MODAL
        =============================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

      <?php

        $crearCliente = new ControladorClientes();
        $crearCliente->ctrCrearCliente();

      ?>

    </div>
  </div>
</div>
