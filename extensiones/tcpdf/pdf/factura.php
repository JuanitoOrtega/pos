<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once('tcpdf_include.php');

class imprimirFactura{

  public $codigo;
  public function traerImpresionFactura() {

    // TRAEMOS LA INFORMACIÓN DE LA VENTA

    $itemVenta = "codigo";
    $valorVenta = $this->codigo;
    $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

    $fecha = substr($respuestaVenta["fecha"], 0, -8);
    $productos = json_decode($respuestaVenta["productos"], true);
    $neto = number_format($respuestaVenta["neto"], 2);
    $impuesto = number_format($respuestaVenta["impuesto"], 2);
    $total = number_format($respuestaVenta["total"], 2);

    // TRAEMOS LA INFORMACIÓN DEL CLIENTE

    $itemCliente = "id";
    $valorCliente = $respuestaVenta["id_cliente"];

    $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

    // TRAEMOS LA INFORMACIÓN DEL VENDEDOR

    $itemVendedor = "id";
    $valorVendedor = $respuestaVenta["id_vendedor"];

    $respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

    // REQUERIMOS LA CLASE TCPDF

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->startPageGroup();
    $pdf->AddPage();

    // El ancho máximo soportado es de 540px en total

    $bloque1 = <<<EOF

      <table>
        <tr>

          <td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
          <td style="background-color:white; width:140px">

            <div style="font-size:8.5px; text-align:right; line-height:15px">

              <strong>NIT:</strong> 1128384722

              <br>
              <strong>Dirección:</strong> Calle Siempre Viva

            </div>

          </td>

          <td style="background-color:white; width:140px">

            <div style="font-size:8.5px; text-align:right; line-height:15px">

              <strong>Teléfono:</strong> 591 36547387

              <br>
              <strong>Correo:</strong> correo@dominio.com

            </div>

          </td>

          <td style="background-color:white; width:110px">

            <div style="font-size:8.5px; text-align:center; line-height:15px; color:red">

              FACTURA NRO:
              <br>
              <strong>$valorVenta</strong>

            </div>

          </td>

        </tr>
      </table>

    EOF;

    $pdf->writeHTML($bloque1, false, false, false, false, '');

    // -------------------------------------------------------

    $bloque2 = <<<EOF

      <table>

        <tr>

          <td style="width:540px"><img src="images/back.jpg"></td>

        </tr>

      </table>

      <table style="font-size:10px; padding:5px 10px">

        <tr>

          <td style="border:1px solid #666; background-color:white; width:390px">
            <strong>Cliente:</strong> $respuestaCliente[nombre]
          </td>

          <td style="border:1px solid #666; background-color:white; width:150px; text-align:right">
            <strong>Fecha:</strong> $fecha
          </td>

        </tr>

        <tr>

          <td style="border:1px solid #666; background-color:white; width:540px">
            <strong>Vendedor:</strong> $respuestaVendedor[nombre]
          </td>

        </tr>

        <tr>

          <td style="border-bottom:1px solid #666; background-color:white; width:540px"></td>

        </tr>

      </table>

    EOF;

    $pdf->writeHTML($bloque2, false, false, false, false, '');

    // -------------------------------------------------------

    $bloque3 = <<<EOF

      <table style="font-size:10px; padding:5px 10px">

        <tr>

          <td style="border:1px solid #666; background-color:white; width:200px; text-align:center"><strong>Producto</strong></td>
          <td style="border:1px solid #666; background-color:white; width:60px; text-align:center"><strong>Imagen</strong></td>
          <td style="border:1px solid #666; background-color:white; width:80px; text-align:center"><strong>Cantidad</strong></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:center"><strong>Valor Unit.</strong></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:center"><strong>Valor Total</strong></td>

        </tr>

      </table>

    EOF;

    $pdf->writeHTML($bloque3, false, false, false, false, '');

    // -------------------------------------------------------

    foreach ($productos as $key => $item) {

      $itemProducto = "descripcion";
      $valorProducto = $item["descripcion"];
      $orden = null;
      $respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

      $precioUnitario = number_format($item["precio"], 2);
      $imagenProducto = $respuestaProducto["imagen"];
      $precioTotal = number_format($item["total"], 2);

      $bloque4 = <<<EOF

        <table style="font-size:10px; padding:5px 10px">

          <tr>

            <td style="border:1px solid #666; color:#333; background-color:white; width:200px; text-align:left">

              - $item[descripcion]

            </td>

            <td style="border:1px solid #666; color:#333; background-color:white; width:60px; text-align:left">

              <img src="../../../$imagenProducto">

            </td>

            <td style="border:1px solid #666; color:#333; background-color:white; width:80px; text-align:center">

              $item[cantidad]

            </td>

            <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:right">

              $ $precioUnitario

            </td>

            <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:right">

              $ $precioTotal

            </td>


          </tr>

        </table>

      EOF;

      $pdf->writeHTML($bloque4, false, false, false, false, '');

    }

    // -------------------------------------------------------

    $bloque5 = <<<EOF

      <table style="font-size:10px; padding:5px 10px">

        <tr>

          <td style="color:#333; background-color:white; width:340px; text-align:center"></td>
          <td style="border-bottom:1px solid #666; background-color:white; width:100px; text-align:center"></td>
          <td style="border-bottom:1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

        </tr>

        <tr>

          <td style="border-right:1px solid #666; color:#333; background-color:white; width:340px"></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:right">

            <strong>Neto:</strong>

          </td>
          <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:right">

            $ $neto

          </td>

        </tr>

        <tr>

          <td style="border-right:1px solid #666; color:#333; background-color:white; width:340px"></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:right">

            <strong>Impuesto:</strong>

          </td>
          <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:right">

            $ $impuesto

          </td>

        </tr>

        <tr>

          <td style="border-right:1px solid #666; color:#333; background-color:white; width:340px"></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:right">

            <strong>Total:</strong>

          </td>
          <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:right">

            $ $total

          </td>

        </tr>

      </table>

    EOF;

    $pdf->writeHTML($bloque5, false, false, false, false, '');

    // -------------------------------------------------------

    // SALIDA DEL ARCHIVO

    $pdf->Output('factura.pdf');

  }
}

$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->traerImpresionFactura();

?>
