document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
});

document.getElementById('sidebarClose').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('open');
});
function toggleFields() {
    var tipoPessoa = document.getElementById("tipoPessoa").value;
    var cpfCnpjLabel = document.querySelector("label[for='cpfCnpj']");
    var cpfCnpjInput = document.getElementById("cpfCnpj");
    var regimeTributarioDiv = document.getElementById("regimeTributarioDiv");
    var ieIsentoDiv = document.getElementById("ieIsentoDiv");
    var ieIsentoCheckbox = document.getElementById("ieIsentoCheckbox");
    var inscricaoEstadualInput = document.getElementById("inscricaoEstadual");

    if (tipoPessoa === "fisica") {
      cpfCnpjLabel.textContent = "CPF";
      cpfCnpjInput.placeholder = "Digite o CPF";
      regimeTributarioDiv.style.display = "none";
      ieIsentoDiv.style.display = "none";
      inscricaoEstadualInput.required = true;
    } else if (tipoPessoa === "juridica") {
      cpfCnpjLabel.textContent = "CNPJ";
      cpfCnpjInput.placeholder = "Digite o CNPJ";
      regimeTributarioDiv.style.display = "block";
      ieIsentoDiv.style.display = "block";
      inscricaoEstadualInput.required = false;
      inscricaoEstadualInput.value = "";
      ieIsentoCheckbox.checked = false;
    }
  }