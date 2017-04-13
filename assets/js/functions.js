function ajaxThis(page, data, onDone, onFail) {
    $.ajax({
        method: "POST",
        url: baseUrl + page,
        data: Object.assign(data, csfrData)
    }).done(function( msg ) {
        if (typeof onDone === "function")
            onDone(msg);
    }).fail(function() {
        if (typeof onFail === "function")
            onFail();
    });
}

$(document).ready(function() {
    $("body").on("click", "#search", function() {
        $(this).closest('form').submit();
    });

    $('a').each(function() {
        var a = new RegExp('/' + window.location.host + '/');

        if(!a.test(this.href) && this.href !== "")
            $(this).attr('target', '_blank');
    });
});