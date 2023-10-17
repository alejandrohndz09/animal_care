var registrosPorPagina = 7;
var paginaActual = 1;
var expedientes = []; // Almacena todos los expedientes

function cargarRegistros(pagina, filtro) {
  var registrosFiltrados = expedientes;

  if (filtro) {
    filtro = filtro.toLowerCase();
    registrosFiltrados = expedientes.filter(function (expediente) {
      return (
        expediente.idExpediente.toLowerCase().includes(filtro) ||
        expediente.animal.nombre.toLowerCase().includes(filtro) ||
        expediente.fechaIngreso.includes(filtro)
      );
    });
  }

  var inicio = (pagina - 1) * registrosPorPagina;
  var fin = inicio + registrosPorPagina;

  var registrosMostrados = registrosFiltrados.slice(inicio, fin);

  var table = document.querySelector("#grid .row");
  table.innerHTML = '';

  if (registrosMostrados.length === 0) {
    table.innerHTML = '<p>No se entregaron registros</p>';
    return;
  }
  // Obtiene la URL actual
  var urlActual = window.location.href;

  // Divide la URL en segmentos usando el carácter '/'
  var segmentos = urlActual.split('/');
  // Accede al último segmento (la última palabra en la URL)
  var ultimaPalabra = segmentos[segmentos.length - 1];


  registrosMostrados.forEach(function (expediente) {
    // Crea la estructura HTML de cada registro y agrega al contenedor
    var columna = document.createElement("div");
    columna.classList.add("col-xl-12", "col-md-6");
    let img;
    if (expediente.animal.imagen == null) {
      img = 'img/especie.png'
    } else {
      img = expediente.animal.imagen;
    }
    if (ultimaPalabra == 'adopcion') {
      columna.innerHTML =
        '<div class="card mb-1 panelGrid d-flex flex-row " style="align-items:center; border: none; padding:.5rem; justify-content:start; gap: 0.7rem !important; width: 100%">' +
        '<a href="/animal/' + expediente.idAnimal + '" class="stretched-link"></a>' +
        '<div class="picture" style="width:60px; height: 60px; overflow: hidden;">' +
        '<img src="' + img + '" style="width:100%; height:100%; object-fit: cover;">' +
        '</div>' +
        '<div style="margin: 0; display: flex; flex-direction:column;">' +
        '<div style="margin: 0; display: flex; align-items: center; font-weight: bold;"> Cod. ' + expediente.idExpediente + '</div>' +
        '<div style="margin: 0; display: flex; align-items: center;color:#6067eb; font-size: 14px"> <i class="fas fa-paw" style="margin-right: 3px;"></i>' + expediente.animal.nombre + '</div>' +
        '<div style="margin: 0; display: flex; align-items: center; color:#867596; font-size: 12px "> <i class="fas fa-calendar" style="margin-right: 3px;"></i>Desde el ' + dateFormat(expediente.fechaIngreso) + '</div>' +
        '</div>' +
        '</div>';
    } else {
      columna.innerHTML =
        '<div class="card mb-1 panelGrid d-flex flex-row " style="align-items:center; border: none; padding:.5rem; justify-content:start; gap: 0.7rem !important; width: 100%">' +
        '<a href="/expElegido/' + expediente.idExpediente + '" class="stretched-link"></a>' +
        '<div class="picture" style="width:60px; height: 60px; overflow: hidden;">' +
        '<img src="' + img + '" style="width:100%; height:100%; object-fit: cover;">' +
        '</div>' +
        '<div style="margin: 0; display: flex; flex-direction:column;">' +
        '<div style="margin: 0; display: flex; align-items: center; font-weight: bold;"> Cod. ' + expediente.idExpediente + '</div>' +
        '<div style="margin: 0; display: flex; align-items: center;color:#6067eb; font-size: 14px"> <i class="fas fa-paw" style="margin-right: 3px;"></i>' + expediente.animal.nombre + '</div>' +
        '<div style="margin: 0; display: flex; align-items: center; color:#867596; font-size: 12px "> <i class="fas fa-calendar" style="margin-right: 3px;"></i>Desde el ' + dateFormat(expediente.fechaIngreso) + '</div>' +
        '</div>' +
        '</div>';
    }

    table.appendChild(columna);
  });

  paginaActual = pagina;
  generarPaginador(registrosFiltrados.length);
}

function generarPaginador(totalRegistros) {
  var paginador = document.querySelector("#paginationGrid");
  paginador.innerHTML = '';

  var totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
  for (var i = 1; i <= totalPaginas; i++) {
    var enlace = document.createElement("a");
    enlace.classList.add('button');
    enlace.classList.add('button-pri');
    enlace.href = "javascript:void(0);";
    enlace.textContent = i;
    enlace.addEventListener("click", function () {
      cargarRegistros(parseInt(this.textContent), document.getElementById("searchInputGrid").value);
    });
    paginador.appendChild(enlace);
  }
}


// Realizar la primera carga de expedientes usando una solicitud AJAX
$.ajax({
  url: '/getExpedientes', // URL de la API en tu servidor
  type: 'GET',
  dataType: 'json',
  success: function (response) {
    expedientes = response;
    console.log(response);
    cargarRegistros(1, ''); // Cargar registros iniciales sin filtro
  },
  error: function (error) {
    console.log(error);
  }
});


// Agregar evento de búsqueda en tiempo real
document.getElementById("searchInputGrid").addEventListener("input", function () {
  cargarRegistros(1, this.value);
});
function dateFormat(fecha) {
  var fechaObjeto = new Date(fecha); // Agrega 'Z' para indicar que la fecha está en UTC
  var anio = fechaObjeto.getUTCFullYear();
  var mes = (fechaObjeto.getUTCMonth() + 1).toString().padStart(2, '0');
  var dia = fechaObjeto.getUTCDate().toString().padStart(2, '0');
  var fechaFormateada = dia + '/' + mes + '/' + anio; // Cambia el formato según tus necesidades
  return fechaFormateada;
}

