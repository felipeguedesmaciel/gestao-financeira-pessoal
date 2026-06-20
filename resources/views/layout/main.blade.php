<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS da Aplicação -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/medias.css">
    <!-- Font do Google -->
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- JS da Aplicação -->
    <script src="js/management.js" defer></script>
    <title>@yield('title')</title>
</head>
<body>
    <header>
        @guest
        <h1 id="initial-title">Gestão Financeira Pessoal</h1>
        @endguest
        @auth
        <ion-icon onclick="clickMenu()" id="burguer" name="reorder-three-sharp"></ion-icon>
        <h1>Gestão Financeira Pessoal</h1>
        <p>Previsão: <button>on/off</button></p>
        <menu id="itens">
            <ion-icon onclick="clickMenu()" name="close" id="close"></ion-icon>
            <ul>
                <li><a href="#itemModal" data-bs-toggle="modal" data-bs-target="#itemModal">Adicionar Compra</a></li>
                <li><a href="#">Adicionar Recebimento</a></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <a href="/logout"
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                        >
                        Sair<ion-icon name="log-out-outline"></ion-icon> </a>
                    </form>
                </li>
            </ul>
        </menu>
        @endauth
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>Desenvolvido por <a href="https://felipeguedesmaciel.github.io/portifolio/" target="_blank">Felipe Maciel</a>&copy;</p>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('category_select');
    const otherGroup = document.getElementById('category_other_group');
    const otherInput = document.getElementById('category_other');
    const hidden = document.getElementById('category_input');

    function updateHidden() {
        if (!select) return;
        if (select.value === 'nova') {
        otherGroup.style.display = '';
        hidden.value = otherInput.value || '';
        } else {
        otherGroup.style.display = 'none';
        hidden.value = select.value;
        }
    }

    if (select) {
        select.addEventListener('change', updateHidden);
        if (otherInput) otherInput.addEventListener('input', function () {
        if (select.value === 'nova') hidden.value = otherInput.value;
        });

        // Popula modal de edição de dívida quando botão for clicado
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.open-edit-debt').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name || '';
                    const initial = this.dataset.initial_debt_amount || '';
                    const agreed = this.dataset.agreed_value || '';
                    const payment_method = this.dataset.payment_method || '';
                    const amount_paid = this.dataset.amount_paid || 0;
                    const installment = this.dataset.installment || '';
                    const payment_date = this.dataset.payment_date || '';
                    const payment_day = this.dataset.payment_day || '';

                    // form action
                    const form = document.getElementById('editDebtForm');
                    if (form) form.action = '/debts/' + id;

                    // populate fields
                    const elName = document.querySelector('#editDebt input[name="name"]');
                    if (elName) elName.value = name;
                    const elInitial = document.querySelector('#editDebt input[name="initial_debt_amount"]');
                    if (elInitial) elInitial.value = initial;

                    // payment method / type
                    const typeSelect = document.getElementById('edit_debt_type');
                    if (typeSelect) {
                        // try to set based on payment_method if contains Parcelado or À vista
                        if (payment_method && payment_method.includes('Parcelado')) {
                            typeSelect.value = 'Parcelado';
                        } else if (payment_method && (payment_method.includes('À vista') || payment_method.toLowerCase().includes('a vista'))) {
                            typeSelect.value = 'À vista';
                        } else {
                            typeSelect.value = '';
                        }
                    }

                    // parcelas
                    const elInstallment = document.getElementById('edit_debt_installment_number');
                    if (elInstallment) elInstallment.value = installment;
                    const elPaymentDate = document.getElementById('edit_payment_date');
                    if (elPaymentDate) elPaymentDate.value = payment_date;
                    const elPaymentDay = document.getElementById('edit_payment_day');
                    if (elPaymentDay) elPaymentDay.value = payment_day;

                    // payment_method and amount_paid
                    const elPaymentMethod = document.querySelector('#editDebt input[name="payment_method"]');
                    if (elPaymentMethod) elPaymentMethod.value = payment_method;
                    const elAmountPaid = document.querySelector('#editDebt input[name="amount_paid"]');
                    if (elAmountPaid) elAmountPaid.value = amount_paid;

                    // toggle visibility based on type
                    const avistaGroup = document.getElementById('edit_debt_avista_payment_date_group');
                    const installmentGroup = document.getElementById('edit_debt_installment_other_group');
                    if (typeSelect && typeSelect.value === 'Parcelado') {
                        if (installmentGroup) installmentGroup.style.display = 'block';
                        if (avistaGroup) avistaGroup.style.display = 'none';
                    } else if (typeSelect && typeSelect.value === 'À vista') {
                        if (installmentGroup) installmentGroup.style.display = 'none';
                        if (avistaGroup) avistaGroup.style.display = 'block';
                    } else {
                        if (installmentGroup) installmentGroup.style.display = 'none';
                        if (avistaGroup) avistaGroup.style.display = 'none';
                    }

                    // calcula valor da parcela e exibe
                    const display = document.getElementById('edit_debt_installment_value_display');
                    if (display) {
                        const a = parseFloat(agreed);
                        const n = parseInt(installment, 10);
                        if (!isNaN(a) && !isNaN(n) && n > 0) {
                            display.textContent = 'R$ ' + a.toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2}) / n;
                        } else display.textContent = '-';
                    }

                    // show modal
                    const modalEl = document.getElementById('editDebt');
                    if (modalEl) {
                        const bsModal = new bootstrap.Modal(modalEl);
                        bsModal.show();
                    }
                });
            });

            const editTypeSelect = document.getElementById('edit_debt_type');
            if (editTypeSelect) {
                editTypeSelect.addEventListener('change', function() {
                    const av = document.getElementById('edit_debt_avista_payment_date_group');
                    const it = document.getElementById('edit_debt_installment_other_group');
                    if (this.value === 'Parcelado') { if (it) it.style.display = 'block'; if (av) av.style.display = 'none'; }
                    else if (this.value === 'À vista') { if (it) it.style.display = 'none'; if (av) av.style.display = 'block'; }
                    else { if (it) it.style.display = 'none'; if (av) av.style.display = 'none'; }
                });
            }
        });
        // inicializa
        updateHidden();
    }
    });

    //Condição de Pagamento type  Parcelado
    document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const installmentGroup = document.getElementById('installment_other_group');
    const installmentInput = document.getElementById('installment');

    if (!typeSelect || !installmentGroup || !installmentInput) return;

    function toggleInstallment() {
        if (typeSelect.value === 'Parcelado') {
        installmentGroup.style.display = '';
        installmentInput.required = true;
        } else {
        installmentGroup.style.display = 'none';
        installmentInput.required = false;
        // opcional: limpar valor quando não é parcelado
        // installmentInput.value = '';
        }
    }

    typeSelect.addEventListener('change', toggleInstallment);
    toggleInstallment();
    });


    // Placeholder do Dia do Vencimento pegando a data da primeira parcela

        document.addEventListener('DOMContentLoaded', function () {
            const firstDate = document.getElementById('payment_date');
            const payDay = document.getElementById('payment_day');

            if (firstDate && payDay) {
                firstDate.addEventListener('change', function (e) {
                    const v = e.target.value; // formato esperado: YYYY-MM-DD
                    if (!v) return;
                    const parts = v.split('-');
                    if (parts.length !== 3) return;
                    const day = parseInt(parts[2], 10);
                    if (isNaN(day)) return;
                    payDay.value = day;
                });
            }
        });

        //Mostra os campos se o valor foi acordado "Sim" no formulário Dívida
        document.addEventListener('DOMContentLoaded', function() {
            // Escuta mudanças em todos os radio buttons do grupo
            document.querySelectorAll('input[name="agreed_value"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // Mostra os campos apenas se "Sim" estiver selecionado
                    document.getElementById('agreement_fields').style.display = (this.value === '1') ? 'block' : 'none';
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const debtTypeSelect = document.getElementById('debt_type');
            const debtInstallmentGroup = document.getElementById('debt_installment_other_group');
            const avistaGroup = document.getElementById('debt_avista_payment_date_group');

            if (!debtTypeSelect) return;

            function toggleDebtFields() {
                if (debtInstallmentGroup)
                    debtInstallmentGroup.style.display = debtTypeSelect.value === 'Parcelado' ? 'block' : 'none';
                if (avistaGroup)
                    avistaGroup.style.display = debtTypeSelect.value === 'À vista' ? 'block' : 'none';
            }

            debtTypeSelect.addEventListener('change', toggleDebtFields);
            toggleDebtFields();
        });

        
        document.addEventListener('DOMContentLoaded', function() {
            const agreedValueInput = document.getElementById('debt_agreed_value');
            const installmentNumberInput = document.getElementById('debt_installment_number');
            const installmentValueDisplay = document.getElementById('debt_installment_value_display');
            const debtTypeSelect = document.getElementById('debt_type');

            if (!agreedValueInput || !installmentNumberInput || !installmentValueDisplay) return;

            function formatCurrency(value) {
                return value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function updateInstallmentValue() {
                const agreedValue = parseFloat(agreedValueInput.value.replace(',', '.'));
                const installments = parseInt(installmentNumberInput.value, 10);

                if (!debtTypeSelect || debtTypeSelect.value !== 'Parcelado') {
                    installmentValueDisplay.textContent = '-';
                    return;
                }

                if (isNaN(agreedValue) || agreedValue <= 0 || isNaN(installments) || installments < 1) {
                    installmentValueDisplay.textContent = '-';
                    return;
                }

                const installmentValue = agreedValue / installments;
                installmentValueDisplay.textContent = `R$ ${formatCurrency(installmentValue)}`;
            }

            agreedValueInput.addEventListener('input', updateInstallmentValue);
            installmentNumberInput.addEventListener('input', updateInstallmentValue);
            debtTypeSelect.addEventListener('change', updateInstallmentValue);
            updateInstallmentValue();
        });

        //### Modal Editar Divida ###
        // Abrindo a Modal 
        const minhaModal = document.getElementById('minhaModal');
        minhaModal.addEventListener('show.bs.modal', function (event) {
        // Botão que acionou a modal
        const button = event.relatedTarget;
        
        // Extrai os atributos data-*
        const id = button.getAttribute('data-id');
        const nome = button.getAttribute('data-nome');
        const initial_debt_amount = button.getAttribute('data-initial_debt_amount');
        const agreed_value = button.getAttribute('data-agreed_value');
        const payment_method = button.getAttribute('data-payment_method');
        const amount_paid = button.getAttribute('data-amount_paid'); 
        const amount_to_pay = button.getAttribute('data-amount_to_pay');
        const type = button.getAttribute('data-type');
        const installment = button.getAttribute('data-installment');
        const payment_date = button.getAttribute('data-payment_date');
        const payment_day = button.getAttribute('data-payment_day');
        
        // Atualiza o conteúdo da modal
        // Seleciona o input dentro do formulário do modal
        const inputNome = minhaModal.querySelector('#modalNome');
        const inputInitial_debt_amount = minhaModal.querySelector('#modalInitial_debt_amount');
        const inputAgreed_value = minhaModal.querySelector('#modalAgreed_value');
        //const inputPayment_method = minhaModal.querySelector('#modalPayment_method');
        const inputAmount_paid = minhaModal.querySelector('#modalAmount_paid'); 
        const inputAmount_to_pay = minhaModal.querySelector('#modalAmount_to_pay');
        // Seleciona o elemento <select> dentro do modal
        const selectType = minhaModal.querySelector('#modalType');
        const inputInstallment = minhaModal.querySelector('#modalInstallment');
        const inputPayment_date = minhaModal.querySelector('#modalPayment_date');
        const inputPayment_day = minhaModal.querySelector('#modalPayment_day');
        // --- LÓGICA DOS RADIOS/CHECKBOX DO ACORDO ---
        const inputCheckSim = minhaModal.querySelector('#agreed_yes');
        const inputCheckNao = minhaModal.querySelector('#agreed_no');

        // Injeta o valor recebido diretamente no campo de texto
        inputNome.value = nome;
        inputInitial_debt_amount.value = initial_debt_amount;
        inputAgreed_value.value = agreed_value;

        // Se houver valor acordado, marca 'Sim', senão marca 'Não'
        if (agreed_value !== null && agreed_value !== '' && agreed_value !== 'null') {
            if (inputCheckSim) inputCheckSim.checked = true; 
            document.getElementById('edit_agreement_fields').style.display ='block';
            if (inputCheckNao) inputCheckNao.checked = false;
        } else {
            if (inputCheckNao) inputCheckNao.checked = true;
            document.getElementById('edit_agreement_fields').style.display ='none';
            if (inputCheckSim) inputCheckSim.checked = false;
        }
        //inputPayment_method.value = payment_method;
        //inputAmount_paid.value = amount_paid; 
        //inputAmount_to_pay.value = amount_to_pay;
        //inputInstallment.value = installment;
        //inputPayment_date.value = payment_date;
        //inputPayment_day.value = payment_day;

        //Limpa opções dinâmicas anteriores (opcional, para não acumular se abrir o modal várias vezes)

        selectType.innerHTML = '';

        //Cria o elemento <option> dinamicamente
        const newOption = document.createElement('option');
        const newOption2 = document.createElement('option');
        const newOption3 = document.createElement('option');

        //Define o valor e o texto da nova opção
        if(type === "Parcelado"){

            newOption2.value = "À Vista";
            newOption2.textContent = "À Vista";

            newOption3.value = "";
            newOption3.textContent = "Selecione...";

            newOption.value = type;
            newOption.textContent = type;
            newOption.selected = true; // Força ela a já vir selecionada

            //Coloca a nova opção dentro do <select>
            selectType.appendChild(newOption);
            selectType.appendChild(newOption2);
            selectType.appendChild(newOption3);

        }else if(type === "À vista"){

            newOption2.value = "Parcelado";
            newOption2.textContent = "Parcelado";

            newOption3.value = "";
            newOption3.textContent = "Selecione...";

            newOption.value = type;
            newOption.textContent = type;
            newOption.selected = true; // Força ela a já vir selecionada

            //Coloca a nova opção dentro do <select>
            selectType.appendChild(newOption);
            selectType.appendChild(newOption2);
            selectType.appendChild(newOption3);

        }else{
            
            newOption2.value = "À Vista";
            newOption2.textContent = "À Vista";

            newOption3.value = "Parcelado";
            newOption3.textContent = "Parcelado";

            newOption.value = "";
            newOption.textContent = "Selecione...";
            newOption.selected = true; // Força ela a já vir selecionada

            //Coloca a nova opção dentro do <select>
            selectType.appendChild(newOption);
            selectType.appendChild(newOption2);
            selectType.appendChild(newOption3);
        }

        const inputData = document.getElementById('cash_payment_date');
        const inputInstallmentData = document.getElementById('date_number_installment');
        if (inputData) {
            // Se vier preenchido pelo botão, mostra. Se vier vazio ("Selecione..."), esconde.
            inputData.style.display = (type === "À vista") ? 'block' : 'none';
            inputInstallmentData.style.display = (type === "Parcelado") ? 'block' : 'none';
            
        }

    });

    // MONITORA MUDANÇA (quando o usuário escolhe na tela) ---
    document.getElementById('modalType').addEventListener('change', function() {
        const inputData = document.getElementById('cash_payment_date');
        const inputInstallmentData = document.getElementById('date_number_installment');
        
        if (inputData) {
            // Se o valor selecionado pelo usuário for "À Vista", exibe o campo "Data de Pagamento"
            if (this.value === "À Vista") {
                inputInstallmentData.style.display = 'none';
                inputData.style.display = 'block';
            } else if(this.value === "Parcelado"){
                // Se o valor selecionado pelo usuário for "Parcelado", exibe os campos "Data da Primeira Parcela", "Número de Parcelas", "Dia do Vencimento" e mostra o "Valor da Parcela".
                inputData.style.display = 'none';
                inputInstallmentData.style.display = 'block';
            }else{
                // Se ele voltar para o "Selecione...", os campos somem novamente
                //inputData.style.display = 'none';
                inputInstallmentData.style.display = 'none';
            }
        }
    });

        
    //Mostra os campos se o valor foi acordado "Sim" no formulário Dívida
    document.addEventListener('DOMContentLoaded', function() {
        // Escuta mudanças em todos os radio buttons do grupo
        document.querySelectorAll('input[name="edit_agreed_value"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Mostra os campos apenas se "Sim" estiver selecionado
                document.getElementById('edit_agreement_fields').style.display = (this.value === '1') ? 'block' : 'none';
            });
        });
    });

        
    </script>
</body>
</html>