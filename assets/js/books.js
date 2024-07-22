document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('buscador');
    const booksContainer = document.getElementById('books-container');
  
    // Guarda una copia de la lista original de tarjetas
    const originalCards = Array.from(booksContainer.getElementsByClassName('card'));
  
    // Función para filtrar y reorganizar las tarjetas de libros
    function filterAndReorganizeBooks() {
      const searchValue = searchInput.value.toLowerCase();
      
      if (searchValue === '') {
        // Restaurar la lista completa cuando el campo de búsqueda está vacío
        originalCards.forEach(card => booksContainer.appendChild(card));
      } else {
        // Filtrar tarjetas según la primera letra del título
        const filteredCards = originalCards.filter(card => {
          const title = card.querySelector('.card-title').textContent.toLowerCase();
          return title.startsWith(searchValue);
        });
  
        // Vacía el contenedor de tarjetas
        booksContainer.innerHTML = '';
  
        // Añadir las tarjetas filtradas
        filteredCards.forEach(card => booksContainer.appendChild(card));
        
        // Añadir las tarjetas que no coinciden al final
        const notFilteredCards = originalCards.filter(card => !filteredCards.includes(card));
        notFilteredCards.forEach(card => booksContainer.appendChild(card));
      }
    }
  
    // Añadir un event listener al input de búsqueda
    searchInput.addEventListener('input', filterAndReorganizeBooks);
  });
  