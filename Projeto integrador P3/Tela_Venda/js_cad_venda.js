$(document).ready(function () {
  // Função para aplicar a máscara de moeda
  function aplicarMascara() {
    $('.preco').inputmask('currency', { prefix: 'R$ ', rightAlign: false });
  }

  // Aplicar máscara aos campos de preço já existentes
  aplicarMascara();

  // Adicionar nova linha de item
  $('.btn-adicionar').click(function () {
    const novaLinha = `
    <div class="row no-gutters item-row">
      <div class="col-md-3">
        <input class="form-control" name="nome_item[]" type="text" size="20">
      </div>
      <div class="col-md-2">
        <input class="form-control" name="codigo[]" type="text" size="20">
      </div>
      <div class="col-md-2">
        <input class="form-control quantidade" name="quantidade[]" type="number" size="20">
      </div>
      <div class="col-md-2">
        <input class="form-control preco" name="preco[]" type="text" size="20">
      </div>
      <div class="col-md-1">
        <input class="form-control desconto" name="desconto[]" type="number" size="20">
      </div>
      <div class="col-md-1">
        <input class="form-control preco-total" name="preco_total[]" type="text" size="20" readonly>
      </div>
      <div class="col-md-1">
        <button type="button" class="btn btn-danger delete-item">Deletar</button>
      </div>
    </div>
    `;
    $('#items-container').append(novaLinha);
    aplicarMascara(); // Reaplicar a máscara aos novos campos
  });

  // Deletar linha de item
  $('#items-container').on('click', '.delete-item', function () {
    $(this).closest('.item-row').remove();
  });

  // Função para calcular o preço total com base no preço, quantidade e desconto
  function calcularPrecoTotal(row) {
    const preco = parseFloat(row.find('.preco').inputmask('unmaskedvalue')) || 0;
    const quantidade = parseFloat(row.find('.quantidade').val()) || 0;
    const desconto = parseFloat(row.find('.desconto').val()) || 0;

    console.log(`Preço: ${preco}, Quantidade: ${quantidade}, Desconto: ${desconto}`); // Log para depuração

    let precoTotal = preco * quantidade;
    if (desconto > 0) {
      precoTotal -= precoTotal * (desconto / 100);
    }

    row.find('.preco-total').val(`R$ ${precoTotal.toFixed(2)}`);
  }

  // Atualizar o preço total ao alterar os campos
  $('#items-container').on('input', '.preco, .quantidade, .desconto', function () {
    const row = $(this).closest('.item-row');
    calcularPrecoTotal(row);
  });

  // Atualizar o preço total ao sair do campo de preço
  $('#items-container').on('blur', '.preco', function () {
    const row = $(this).closest('.item-row');
    calcularPrecoTotal(row);
  });
});
