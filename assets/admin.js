jQuery(function ($) {

    $('.mdict-install').click(function (e)
    {
        let btn_obj = $(this);
        let data_file_name = btn_obj.data('file_name');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: mdict_admin_vars.ajaxurl,
            data: {
                action: 'mdict_import_data',
                data_file: data_file_name
            },
            beforeSend: function (xhr) {
                btn_obj.parent().find('.progress_loading,.install-note').show();
                btn_obj.text(mdict_admin_vars.installing);
                btn_obj.attr('disabled', 'disabled');

            },

            success: function (res) {
                console.log(res);
                btn_obj.parent().find('.progress_loading,.install-note').hide();
                if (res.result == 1)
                {
                    btn_obj.attr('disabled', 'disabled');
                    btn_obj.text(mdict_admin_vars.installed);
                } else
                {
                    btn_obj.removeAttr('disabled');
                    btn_obj.text(mdict_admin_vars.install);
                    alert(res.error);
                }
            },
            error: function (error) {
                btn_obj.parent().find('.progress_loading,.install-note').hide();
                console.log(error);
                btn_obj.removeAttr('disabled');
                btn_obj.text(mdict_admin_vars.install);
                alert(error);

            }
        });

    });


});