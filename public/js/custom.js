$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // Verifica se a tabela já possui um DataTable
    if (!$.fn.DataTable.isDataTable('.table-datatable')) {
        $('.table-datatable').DataTable({
            language: {
                url: datatableLangUrl
            },
            stateSave: true,
        });

        // Aplica o filtro ao DataTable
        if (filter) {
            if (isValidDate(filter)) {
                // Converte a data para o formato 'DD/MM/YYYY'
                newDate = formatDate(filter);
                table.search(newDate).draw();
            }
            else {
                table.search(filter).draw();
            }
        }
    }

    $('.km-mask-input').mask('#.##0,0', { reverse: true });
    $('.peso-mask-input').mask('#.##0,00', { reverse: true });
    $('.litros-mask-input').mask('#.##0,00', { reverse: true });
    $('.valor-mask-input').mask('#.##0,00', { reverse: true });
    $('.data-mask-input').mask('00/00/0000');

    // $('.placa-mask-input').mask(['AAA-9999','AAA9A99'], { translation: {
    //     'A': { pattern: /[A-Za-z]/ },
    //     '9': { pattern: /[0-9]/ }
    // } });

    // Quando mudar o item selecionado, faz a aplicação em outro campo
    $(".aplica-valor").on("change", function () {
        // Pega o valor selecionado no select
        var item = $(this).find("option:selected");
        // Obtém o valor a ser atribuido a partir do atributo data-value
        var valor = item.data("value");
        // Obtém o input a ser atribuido a partir do atributo data-input
        var input = item.data("input");

        // Atualiza o valor do campo "valor"
        $('#'+input).val(valor.toFixed(2));

        // aplica mascara novamente
        $('#'+input).unmask();
        $('#'+input).mask('#.##0,00', { reverse: true });
    });
    
    // Quando o radio button for alterado
    $(".abre-campos").change(function() {
        var campo = $(this).closest(".linha-form").find('.campos-form');
        if (this.value === '1') {
            campo.show();
        } else {
            campo.hide();
        }
    }).change();

    // tratamento para salvar
    $('.form-loading-submit').submit(function () {
        // Verifica se o formulário já foi enviado
        if ($(this).data('enviado')) {
            // Se o formulário já foi enviado, cancela a submissão
            event.preventDefault();
            return;
        }

        // Marca o formulário como enviado
        $(this).data('enviado', true);

        // Seleciona o botão de submit dentro do formulário
        var $btnSalvar = $(this).find('button[type="submit"]');
        // Cria o elemento de indicador de carregamento
        var $btnLoading = $(
            `<button class="btn btn-success" type="button" disabled>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">Salvando...</span>
            </button>`
        );

        // Esconde o botão de Salvar e adiciona o indicador de carregamento
        $btnSalvar.addClass('d-none').after($btnLoading);
    });

});