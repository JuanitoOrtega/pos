<?php

$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

$arrayVendedores = array();
$arrayListaVendedores = array();

foreach ($ventas as $key => $valueVentas) {
  foreach ($usuarios as $key => $valueUsuarios) {
    if($valueUsuarios["id"] == $valueVentas["id_vendedor"]){
      #Capturamos los vendedores en un array
      array_push($arrayVendedores, $valueUsuarios["nombre"]);

      #Capturamos los nombres y el valor total de la venta en un mismo array
      $arrayListaVendedores = array($valueUsuarios["nombre"] => $valueVentas["total"]);

      #Sumamos los netos de cada vendedor
      foreach ($arrayListaVendedores as $key => $value) {
        $sumaTotalVendedores[$key] += $value;
      }
    }
  }
}

#Evitamos repetir nombres
$noRepetirNombres = array_unique($arrayVendedores);

?>

<!--=============================================
VENDEDORES
==============================================-->

<div class="box box-info">
  <div class="box-header with-border">

    <h3 class="box-title">Vendedores</h3>

  </div>

  <div class="box-body">

    <div class="chart-responsive">
      <div class="chart" id="bar-chart1" style="height:300px">

      </div>
    </div>

  </div>

</div>

<script>

//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart1',
  resize: true,
  data: [

    <?php

    foreach ($noRepetirNombres as $value) {
      echo "{y: '".$value."', a: '".$sumaTotalVendedores[$value]."'},";
    }

    ?>

  ],
  barColors: ['#0af'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Ventas'],
  preUnits: '$',
  hideHover: 'auto'
});

</script>
