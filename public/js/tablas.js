
const itemsPerPage = 7; // Cambia esto al número deseado de elementos por página
const searchInput = document.getElementById('searchInput');//$("#searchInput"); 
const tableBody = document.getElementById('tableBody');//$("#tableBody"); 
const pagination = document.getElementById('pagination');//$("pagination"); 

let currentPage = 1;
let originalData = Array.from(tableBody.children);
let currentData = [...originalData];

function displayData(data) {
  tableBody.innerHTML = '';
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;

  for (let i = startIndex; i < endIndex && i < data.length; i++) {
    tableBody.appendChild(data[i]);
  }
}

function updatePagination() {
  const totalPages = Math.ceil(currentData.length / itemsPerPage);
  pagination.innerHTML = '';

  if (totalPages > 1) {
    for (let i = 1; i <= totalPages; i++) {
      const pageLink = document.createElement('a');
        pageLink.href = 'javascript:void(0)';
        pageLink.classList.add('button');
        pageLink.classList.add('button-pri');
      pageLink.textContent = i;
      pageLink.addEventListener('click', () => {
        currentPage = i;
        displayData(currentData);
        updatePagination();
      });
      pagination.appendChild(pageLink);
    }
  }

  if (currentData.length === 0) {
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
            console.error('Error al cargar.', error);
        });
    
        newCell.style.width = '100%';
    // Agregar el <td> como hijo del <tr>
    newRow.appendChild(newCell);
    
    // Agregar el <tr> al <tbody> de la tabla
    tableBody.appendChild(newRow);
  } else {
    displayData(currentData);
  }
}

searchInput.addEventListener('input', (event) => {
  const query = event.target.value.trim().toLowerCase();
  currentData = originalData.filter((row) => {
    const rowData = Array.from(row.getElementsByTagName('td'));
    return rowData.some((cell) =>
      cell.textContent.toLowerCase().includes(query)
    );
  });
  currentPage = 1;
  updatePagination();
});

// Inicialización
updatePagination();