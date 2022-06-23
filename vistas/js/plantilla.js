/*=============================================
Limpia la Imagen de los Modales
=============================================*/

$('.modal').on('hidden.bs.modal', function () {

    $(this).find('form')[0].reset();
    $(".alert").remove();

 	/*=============================================
	Para limpiar la imagen
	=============================================*/

    let id = this.id;

	if(id.search("Usuario")>0){

		$(".previsualizar").attr("src", "vistas/img/usuarios/default/anonymous.png");

	} else {

		if(id.search("Producto")>0){

			$(".previsualizar").attr("src", "vistas/img/productos/default/anonymous.png");

		}

	}

})

/*=============================================
SideBar Menu
=============================================*/

$('.sidebar-menu').tree();

/*=============================================
Data Table
=============================================*/

$('.tablas').DataTable({

	"language": {

		"sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ registros",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
        "sFirst":    	   "Primero",
        "sLast":     	   "Último",
        "sNext":     	   "Siguiente",
        "sPrevious":	   "Anterior"
    	},
    	"oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    	}
	}
})

/*=============================================
iCheck for checkbox and radio inputs
=============================================*/

$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
  checkboxClass: 'icheckbox_flat-green',
  radioClass   : 'iradio_flat-green'
})

/*=============================================
InputMask
=============================================*/

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//Money Euro
$('[data-mask]').inputmask()
