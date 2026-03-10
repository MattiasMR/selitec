(function ($) {
  'use strict';

  var $table = $('#the-list');
  if (!$table.length) return;

  $table.sortable({
    items: 'tr',
    axis: 'y',
    cursor: 'grabbing',
    opacity: 0.65,
    placeholder: 'curso-sortable-placeholder',
    helper: function (_e, row) {
      // Preserve column widths while dragging
      row.children().each(function () {
        $(this).width($(this).width());
      });
      return row;
    },
    update: function () {
      var ids = [];
      $table.find('tr').each(function () {
        var id = $(this).attr('id');
        if (id) {
          ids.push(parseInt(id.replace('post-', ''), 10));
        }
      });

      if (!ids.length) return;

      $.post(cursoOrder.ajaxUrl, {
        action: 'update_curso_order',
        nonce: cursoOrder.nonce,
        order: ids,
      });
    },
  });

  // Give draggable rows a grab cursor
  $table.find('tr').css('cursor', 'grab');
})(jQuery);
