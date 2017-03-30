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