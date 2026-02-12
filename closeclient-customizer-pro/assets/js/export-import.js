
jQuery(document).ready(function($) {
    $('.closeclient-export-button').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'closeclient_customizer_export',
                nonce: $('#closeclient_customizer_export_import_nonce').val()
            },
            success: function(response) {
                var data = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(response.data));
                var a = document.createElement('a');
                a.setAttribute("href", data);
                a.setAttribute("download", "closeclient-settings.json");
                a.click();
            }
        });
    });

    $('#customize-control-closeclient_import_file input[type="file"]').on('change', function() {
        var file = $(this)[0].files[0];
        var formData = new FormData();
        formData.append('file', file);
        formData.append('action', 'closeclient_customizer_import');
        formData.append('nonce', $('#closeclient_customizer_export_import_nonce').val());
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                wp.customize.previewer.refresh();
            }
        });
    });

    $('.closeclient-reset-button').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to reset all settings?')) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'closeclient_customizer_reset',
                    nonce: $('#closeclient_customizer_export_import_nonce').val()
                },
                success: function(response) {
                    wp.customize.previewer.refresh();
                }
            });
        }
    });
});
