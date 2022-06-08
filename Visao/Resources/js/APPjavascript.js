function preenchido(dado) {
    if (dado == null || dado == '') {
        return false;
    }
    return true;
}

function habilita(componenteId) {
    var componente = $('#' + componenteId);

    if (componente.is("button")) {
        componente.removeAttr("disabled");
    }
    if (componente.is("input") || componente.is("textarea")) {
        componente.removeAttr("readonly");
    }
}

function desabilita(componenteId) {
    var componente = $('#' + componenteId);

    if (componente.is("button")) {
        componente.removeAttr("disabled");
        componente.attr("disabled", "disabled");

    }
    if (componente.is("input") || componente.is("textarea")) {
        componente.removeAttr("readonly");
        componente.attr("readonly", "readonly");
    }
}



function grid(htmlId, ajaxUrl, botoesEventos, colDefs, tamanhoPaginacao) {
    var obj = null;

    obj = $('#' + htmlId).DataTable({
        dom: 'Bfrtip',
        ajax: ajaxUrl,
        select: 'single',
        destroy: true,
        pagingType: "full_numbers",
        pageLength: tamanhoPaginacao,
        keys: true,
        buttons: botoesEventos,
        columnDefs: colDefs,
        language: {
            decimal: "",
            emptyTable: "Não há registros",
            info: "Exibindo _START_ até _END_ de um total _TOTAL_ ",
            infoEmpty: "Exibindo 0 até 0 de 0",
            infoFiltered: "(filtrando de um total de _MAX_ )",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Show _MENU_ entries",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            search: "Filtrar:",
            zeroRecords: "Registros não encontrados",
            paginate: {
                first: "Primeiro",
                last: "Últ.",
                next: ">>",
                previous: "<<"
            }
        }
    });
    return obj;
}

function gridCorMateriais(htmlId, ajaxUrl, botoesEventos, colDefs, tamanhoPaginacao) {
    var obj = null;

    obj = $('#' + htmlId).DataTable({
        dom: 'Bfrtip',
        ajax: ajaxUrl,
        select: 'single',
        destroy: true,
        pagingType: "full_numbers",
        pageLength: tamanhoPaginacao,
        keys: true,
        buttons: botoesEventos,
        columnDefs: colDefs,
        language: {
            decimal: "",
            emptyTable: "Não há registros",
            info: "Exibindo _START_ até _END_ de um total _TOTAL_ ",
            infoEmpty: "Exibindo 0 até 0 de 0",
            infoFiltered: "(filtrando de um total de _MAX_ )",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Show _MENU_ entries",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            search: "Filtrar:",
            zeroRecords: "Registros não encontrados",
            paginate: {
                first: "Primeiro",
                last: "Últ.",
                next: ">>",
                previous: "<<"
            }
        },
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td', nRow).closest('tr').css('background', parseFloat(aData[6]) < parseFloat(aData[5]) ? '#F2BE71' : '');
        }
    });
    return obj;
}

function relogio(duracao, htmlId) {
    var start = Date.now();
    var diff;
    var minutes;
    var seconds;
    
    function timer() {
        diff = duracao - (((Date.now() - start) / 1000) | 0);

        minutes = (diff / 60) | 0;
        seconds = (diff % 60) | 0;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        htmlId.text(  minutes + ":" + seconds );

        if (diff <= 0) {
            start = Date.now() + 1000;
        }
    };

    timer();
    setInterval(timer, 1000);
}