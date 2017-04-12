$(document).ready(function() {
    $("#form_description_new").summernote({
        height: 200,
        minHeight: 100,
        maxHeight: 300
    });

    $("body").on("keyup", "#form_tags", function() {
        if (/\s+,/g.test($(this).val()) || /,\s+/g.test($(this).val()))
            $(this).val($(this).val().replace(/\s*,\s*/g, ','));
    });

    $("body").on("mouseover mouseout click", "#content", function(event) {
        var buttonEditShow = $("#editPost").is(":visible");
        var showHideButton;

        if ((event.type === "mouseover" || event.type === "click") && !buttonEditShow) {
            showHideButton = "show";
        }

        if (event.type === "mouseout" && buttonEditShow) {
            showHideButton = "hide";
        }

        if (showHideButton === "show")
            $("#editPost").show();
        else if (showHideButton === "hide")
            $("#editPost").hide();
    });

    $("body").on("click", "#editPost", function() {

        if ($(".note-editor").length == 0) {
            $("#content").find("h3:eq(0)").html('<input type="text" id="editPostTitle" class="form-control" placeholder="Заглавие" value="'+$("#content").find("h3:eq(0)").text()+'" />');
            $("#content").find("div#description").summernote();
        } else {
            $("#content").find("h3:eq(0)").text($("#editPostTitle").val());
            $("#content").find("div#description").summernote("destroy");

            var id = $("#content").attr("data-post-id");
            var title = $("#content").find("h3:eq(0)").text();
            var description = $("#content").find("div#description").html().trim();

            ajaxThis("Admin/New_post/editPost", {'id': id, 'title': title, 'description' : description});
        }
    });
});