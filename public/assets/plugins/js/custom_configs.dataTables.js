
// monta a tabela
function dataTableContruct(selector, ajaxUrl, typeReq, columns, lang, baseRedirectUrl) {

  const table = $(selector).DataTable({
      serverSide: true, // Ativa o processamento no servidor
      processing: true, // Exibe um indicador de carregamento
      stateSave: true,
      stateSaveCallback: function(settings, data) {
          sessionStorage.setItem('DataTables_'+selector, JSON.stringify(data));
      },

      stateLoadCallback: function(settings) {
          return JSON.parse(sessionStorage.getItem('DataTables_'+selector));
      },
      ajax: {
          url: ajaxUrl, // URL do arquivo PHP
          type: typeReq // Método HTTP
      },
      pageLength: 25,
      searching: true, // Ativa a pesquisa
      paging: true,    // Ativa a paginação
      columns: columns,
      createdRow: function (row, data, dataIndex) {
          // Aqui você define o data-id no <tr>
          $(row).attr('data-id', data.id);
      },
      language: {
          "url": lang
      },
      
  });

  const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

  let selectedRow = null;

if (isTouchDevice) {
  // Ação com 1 clique em mobile/tablet
  $(selector + ' tbody').on('click', 'tr', function () {
    const id = $(this).data('id');
    if (id) window.location.href = `/${baseRedirectUrl}/${id}`;
  });
} else {
  // Clique simples: seleciona
  $(selector + ' tbody').on('click', 'tr', function () {
    if ($(this).hasClass('selected')) {
      $(this).removeClass('selected');
      selectedRow = null;
    } else {
      $(selector + ' tr.selected').removeClass('selected');
      $(this).addClass('selected');
      selectedRow = this;
    }
  });

  // Clique duplo: acessa
  $(selector + ' tbody').on('dblclick', 'tr', function () {
    const id = $(this).data('id');
    if (id) window.location.href = `/${baseRedirectUrl}/${id}`;
  });

  // Setas ↑ ↓ e Enter
  $(document).on('keydown', function (e) {
    if (!selectedRow) return;

    const $selected = $(selectedRow);

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      const $next = $selected.next('tr');
      if ($next.length) {
        $selected.removeClass('selected');
        $next.addClass('selected');
        selectedRow = $next.get(0);
      }
    }

    if (e.key === 'ArrowUp') {
      e.preventDefault();
      const $prev = $selected.prev('tr');
      if ($prev.length) {
        $selected.removeClass('selected');
        $prev.addClass('selected');
        selectedRow = $prev.get(0);
      }
    }

    if (e.key === 'Enter') {
      const id = $selected.data('id');
      if (id) window.location.href = `/${baseRedirectUrl}/${id}`;
    }
  });
}


  return table;  
}