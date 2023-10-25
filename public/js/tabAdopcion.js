var registrosPorPagina = 7;
var paginaActual = 1;
var adopciones = []; // Almacena todos los adopciones

function cargarRegistros(pagina, filtro) {
  var registrosFiltrados = adopciones;

  if (filtro) {
    filtro = filtro.toLowerCase();
    registrosFiltrados = adopciones.filter(function (adopcion) {
      return (
        adopcion.idAdopcion.toLowerCase().includes(filtro) ||
        adopcion.expediente.animal.nombre.toLowerCase().includes(filtro) ||
        adopcion.fechaTramiteInicio.includes(filtro)
      );
    });
  }

  var inicio = (pagina - 1) * registrosPorPagina;
  var fin = inicio + registrosPorPagina;

  var registrosMostrados = registrosFiltrados.slice(inicio, fin);

  var table = document.querySelector("#grid .row");
  table.innerHTML = '';

  if (registrosMostrados.length === 0) {
    const newRow = document.createElement('tr');
    
    // Crear un nuevo elemento <td>
    const newCell = document.createElement('td');
    
    // Realizar una solicitud AJAX para cargar el contenido del archivo
    fetch('/html/loader.html')
        .then(response => response.text())
        .then(data => {
            // Establecer el contenido del <td> con el HTML cargado del archivo
            newCell.innerHTML = data;
        })
        .catch(error => {
            console.error('Error al cargar', error);
        });
    
        newCell.style.width = '100%';
    // Agregar el <td> como hijo del <tr>
    newRow.appendChild(newCell);
    
    // Agregar el <tr> al <tbody> de la tabla
    table.appendChild(newRow);
    return;
  }
  // Obtiene la URL actual
  var urlActual = window.location.href;

  // Divide la URL en segmentos usando el carácter '/'
  var segmentos = urlActual.split('/');
  // Accede al último segmento (la última palabra en la URL)
  var ultimaPalabra = segmentos[segmentos.length - 1];


  registrosMostrados.forEach(function (adopcion) {
    // Crea la estructura HTML de cada registro y agrega al contenedor
    var columna = document.createElement("div");
    columna.classList.add("col-xl-12", "col-md-6");
    let img;
    if (adopcion.expediente.animal.imagen == null) {
      img = '/img/especie.png'
    } else {
      img = '/'+adopcion.expediente.animal.imagen;
    }
    let estado = '<span class="badge rounded-pill alert-secondary">En espera de ser aprobado</span>';
    let fechaFin = '';
    if (adopcion.aceptacion == 1) {
      estado = '<span class="badge rounded-pill alert-success">Trámite aprobado</span>';
      fechaFin = '<div  style="margin: 0; display: flex; align-items: center; color:#867596; justify-content:end; font-size: 12px "> <i class="fas fa-calendar" style="margin-right: 3px;"></i>Finalizado el ' + dateFormat(adopcion.fechaTramiteFin) + '</div>';
    } else if (adopcion.aceptacion == 2) {
      estado = '<span class="badge rounded-pill alert-danger">Trámite denegado</span>';
      fechaFin = '<div  style="margin: 0; display: flex; align-items: center; color:#867596; justify-content:end; font-size: 12px "> <i class="fas fa-calendar" style="margin-right: 3px;"></i>Finalizado el ' + dateFormat(adopcion.fechaTramiteFin) + '</div>';
    }
    if (ultimaPalabra == 'adopcion') {

      columna.innerHTML =
        '<div class="card mb-1 panelGrid d-flex flex-row px-3" style="align-items:center; border: none; padding:.5rem; justify-content:start; gap: 0.7rem !important; width: 100%">' +
        '<a href="/adopcion/' + adopcion.idAdopcion + '" class="stretched-link"></a>' +
          '<div class="picture" style="width:60px; height: 60px; overflow: hidden;">' +
            '<img src="' + img + '" style="width:100%; height:100%; object-fit: cover;">' +
          '</div>' +
          '<div style="margin: 0; display: flex; flex-direction:column;">' +
            '<div style="margin: 0; display: flex; align-items: center; font-weight: bold;"> Cod. ' + adopcion.idAdopcion + '</div>' +
            '<div style="margin: 0; display: flex; align-items: center;color:#6067eb; font-size: 14px"> <i class="fas fa-paw" style="margin-right: 3px;"></i>' + adopcion.idExpediente+' - '+ adopcion.expediente.animal.nombre + '</div>' +
            '<div style="margin: 0; display: flex; align-items: center; color:#867596; font-size: 12px "> <i class="fas fa-calendar" style="margin-right: 3px;"></i>Trámite iniciado el ' + dateFormat(adopcion.fechaTramiteInicio) + '</div>' +
          '</div>' +
          '<div class="flex-grow-1" style="margin: 0; display: flex; flex-direction:column;">' +
            '<div style="margin: 0; display: flex; align-items: center;color:#6067eb; justify-content:end;">' +estado + '</div>' +
            fechaFin+
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
        '<div style="margin: 0; display: flex; align-items: center; font-weight: bold;"> Cod. ' + adopcion.idExpediente + '</div>' +
        '<div style="margin: 0; display: flex; align-items: center;color:#6067eb; font-size: 14px"> <i class="fas fa-paw" style="margin-right: 3px;"></i>' + adopcion.animal.nombre + '</div>' +
        '<div style="margin: 0; display: flex; align-items: center; color:#867596; font-size: 12px "> <i class="fas fa-calendar" style="margin-right: 3px;"></i>Desde el ' + dateFormat(adopcion.fechaIngreso) + '</div>' +
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


// Realizar la primera carga de adopciones usando una solicitud AJAX
$.ajax({
  url: '/getAdopciones', // URL de la API en tu servidor
  type: 'GET',
  dataType: 'json',
  success: function (response) {
    adopciones = response;
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

