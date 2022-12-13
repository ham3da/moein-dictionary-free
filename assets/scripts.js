function mdict_addQueryParam(url, key, val) {
    var parts = url.match(/([^?#]+)(\?[^#]*)?(\#.*)?/);
    var url = parts[1];
    var qs = parts[2] || '';
    var hash = parts[3] || '';

    if (!qs) {
        return url + '?' + key + '=' + encodeURIComponent(val) + hash;
    } else {
        var qs_parts = qs.substr(1).split("&");
        var i;
        for (i = 0; i < qs_parts.length; i++) {
            var qs_pair = qs_parts[i].split("=");
            if (qs_pair[0] == key) {
                qs_parts[ i ] = key + '=' + encodeURIComponent(val);
                break;
            }
        }
        if (i == qs_parts.length) {
            qs_parts.push(key + '=' + encodeURIComponent(val));
        }
        return url + '?' + qs_parts.join('&') + hash;
    }
}

jQuery(function ($) {

    $('#mdict-word').autocomplete({"source":
                function (request, response) {
                    $.ajax({
                        type: 'post',
                        url: mdict_vars.ajaxurl,
                        data: {
                            action: 'mdict_search_word',
                            word: request.term
                        },
                        success: function (res) {
                            response($.map(res.data, function (item) {

                                return {
                                    value: item.Word,
                                    id: item.id,
                                    label: item.Word,
                                    url: mdict_addQueryParam(mdict_vars.mdict_current_page, 'wid', item.id)
                                };
                            }));
                        }
                    });
                }
        , "response":
                function (event, ui) {
                    if (event.keyCode == 13) {
                        //window.location.href = 'https://dehkhoda.ut.ac.ir/fa/dictionary/?DictionarySearch[word]=' + ui.item.text
                    }
                }
        , "autoFocus": false, "minLength": "2", "select":
                function (event, ui) {
                    window.location.href = ui.item.url
                }
    });

    $('.mdict-print').click(function (e)
    {
        $(".mdic-description-parent").print({
            globalStyles: true,
            mediaPrint: true,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            doctype: '<!doctype html>'
        });
    });
   
});