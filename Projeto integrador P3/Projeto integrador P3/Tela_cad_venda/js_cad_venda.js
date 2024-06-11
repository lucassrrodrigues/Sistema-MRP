document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.btn-adicionar').addEventListener('click', function () {
      var itemsContainer = document.getElementById('items-container');
      var newItemRow = document.querySelector('.item-row').cloneNode(true);
      newItemRow.querySelectorAll('input').forEach(function (input) {
        input.value = ''; // Limpar os valores dos novos campos
      });
      itemsContainer.appendChild(newItemRow);
    });

    // Event listener para deletar item
    document.addEventListener('click', function (event) {
      if (event.target.classList.contains('delete-item')) {
        event.target.closest('.item-row').remove();
      }
    });
  });