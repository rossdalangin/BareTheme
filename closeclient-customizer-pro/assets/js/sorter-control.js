
jQuery(document).ready(function($) {
    $('.sorter-list').sortable({
        handle: '.handle',
        update: function(event, ui) {
            updateSorterValue( $(this) );
        }
    });

    $('.sorter-checkbox').on('change', function() {
        updateSorterValue( $(this).closest('.sorter-list') );
    });

    function updateSorterValue(list) {
        var newValue = {};
        list.find('li').each(function() {
            var value = $(this).data('value');
            var enabled = $(this).find('.sorter-checkbox').is(':checked');
            newValue[value] = enabled;
        });
        list.closest('.sorter-container').next('input').val(JSON.stringify(newValue)).trigger('change');
    }
});
