// Variáveis para controle do formulário
let currentStep = 0;
const formSteps = document.querySelectorAll('.form-step');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const submitBtn = document.querySelector('.submit-btn');

// Função para avançar para a próxima etapa
function nextStep() {
    if (currentStep < formSteps.length - 1) {
        formSteps[currentStep].style.display = 'none';
        currentStep++;
        formSteps[currentStep].style.display = 'block';
        updateButtons();
    }
}

// Função para voltar para a etapa anterior
function prevStep() {
    if (currentStep > 0) {
        formSteps[currentStep].style.display = 'none';
        currentStep--;
        formSteps[currentStep].style.display = 'block';
        updateButtons();
    }
}

// Função para atualizar o estado dos botões de navegação
function updateButtons() {
    if (currentStep === 0) {
        prevBtn.style.display = 'none'; // Oculta o botão "Anterior" na primeira etapa
        nextBtn.style.width = '35%'; // Faz o botão "Próximo" ocupar 100% da largura na primeira etapa
    } else {
        prevBtn.style.display = 'inline-block'; // Exibe o botão "Anterior" nas outras etapas
        nextBtn.style.width = '49%'; // Retorna o botão "Próximo" ao seu tamanho original nas outras etapas
    }

    if (currentStep === formSteps.length - 1) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'inline-block';
    } else {
        nextBtn.style.display = 'inline-block';
        submitBtn.style.display = 'none';
    }
}

// Inicialização
updateButtons();
// Definindo currentStep como 0 na inicialização para garantir que a primeira tela exibida seja a primeira etapa
currentStep = 0;
formSteps[currentStep].style.display = 'block';

// Formatação automática de RG, CPF e telefones
document.getElementById('rg').addEventListener('input', function (e) {
    var value = e.target.value.replace(/\D/g, '');
    if (value.length === 9) {
        e.target.value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{1})$/, '$1.$2.$3-$4');
    } else {
        e.target.value = value;
    }
});

document.getElementById('cpf').addEventListener('input', function (e) {
    var value = e.target.value.replace(/\D/g, '');
    if (value.length === 11) {
        e.target.value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
    } else {
        e.target.value = value;
    }
});

document.getElementById('telefone_residencial').addEventListener('input', function (e) {
    var value = e.target.value.replace(/\D/g, '');
    if (value.length === 11) {
        e.target.value = value.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, '($1) $2 $3-$4');
    } else if (value.length === 10) {
        e.target.value = value.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
    } else {
        e.target.value = value;
    }
});

document.getElementById('telefone_celular').addEventListener('input', function (e) {
    var value = e.target.value.replace(/\D/g, '');
    if (value.length === 11) {
        e.target.value = value.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, '($1) $2 $3-$4');
    } else if (value.length === 10) {
        e.target.value = value.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
    } else {
        e.target.value = value;
    }
});
function toggleCard(card) {
    card.classList.toggle('selected');
}
