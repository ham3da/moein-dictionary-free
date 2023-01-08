//Selection Menu
jQuery(function ($)
{

    var $meaning = $('<a>'+mdict_vars.mean_search+'</a>').css({
        // boxShadow: '10px 0 0 -9px rgba(255,255,255,0.2), -10px 0 0 -9px rgba(255,255,255,0.2)'
    });


    var $mdict_tooltip = $('<div>').addClass('mdict-tooltip').css({
        transform: 'scale(0)',
        transformOrigin: 'top',
        position: 'absolute',
        height: '2.5em',
        width: 'auto',
        padding: '5px 10px',
        borderRadius: '10px',
        display: 'flex',
        justifyContent: 'right',
        alignItems: 'center',
        background: 'rgba(14,17,17,0.9)'
    }).append($meaning);

    $(document.body).append($mdict_tooltip);

    var prevtext = '';
    document.addEventListener('selectionchange', function () {
        var sel = window.getSelection() || document.getSelection();
        var text = sel.toString().trim();
        // if (sel.isCollapsed || !sel.rangeCount) {
        if (!text) {
            $mdict_tooltip.css({transform: 'scale(0)'});
            prevtext = '';
            return;
        }


        $meaning.attr({
            href: mdict_addQueryParam(mdict_vars.mdict_page, 'word', text),
            title: mdict_vars.mdict_search_des,
            target: '_blank'
        });



        var rect = sel.getRangeAt(0).getBoundingClientRect();
        $mdict_tooltip.css({
            transform: 'scale(1)',
            transition: 'none'
        });
        tooltipWidth = $mdict_tooltip[0].getBoundingClientRect().width;
        if (!prevtext) {
            $mdict_tooltip.css({
                transform: 'scale(0)',
                transition: 'none'
            });
        }
        $mdict_tooltip.css({
            transform: 'scale(1)',
            transition: 'transform 0.2s ease-out',
            top: rect.top + $(window).scrollTop(),
            left: rect.right - tooltipWidth
        });
        prevtext = text;
    });
});