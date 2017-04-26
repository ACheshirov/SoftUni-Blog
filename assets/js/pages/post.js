$(document).ready(function() {
    $("#form_description_new").summernote({
        height: 200,
        minHeight: 100,
        maxHeight: 300
    });

    function tagsInputChange(el) {
        if (/\s+,/g.test(el.val()) || /,\s+/g.test(el.val()))
            el.val(el.val().replace(/\s*,\s*/g, ','));
    }

    $("body").on("keyup", "#form_tags", function() {
        tagsInputChange($(this));
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
            var categories = '';
            var currentCategory = $("#category").text().trim();

            $("#categoriesAll").text().split("\t\t").forEach(function(val) {
                var cat = val.split("\t");
                categories += '<option value="'+cat[0]+'"'+((currentCategory === cat[1]) ? ' selected="selected"' : '')+'>'+cat[1]+'</option>';
            });

            $("#category").html('<select id="categorySelect">'+categories+'</select>');
            $("#tags").html('<input type="text" id="form_tags" class="form-control" placeholder="Тагове" value="'+$("#tags").text().trim()+'" />');
            tagsInputChange($('#form_tags'));
        } else {
            $("#content").find("h3:eq(0)").text($("#editPostTitle").val());
            $("#content").find("div#description").summernote("destroy");

            var categoryId = $('#categorySelect').find(":selected").val();
            var categoryName = $('#categorySelect').find(":selected").text();

            $("#category").html('<i class="fa fa-folder-open"></i> <a href="'+baseUrl+'category/'+categoryId+'">'+categoryName+'</a>');

            var tags = [];
            $("#form_tags").val().split(",").forEach(function(val) {
                var tag = val.trim();
                if (tag.length > 0) {
                    tags.push(tag);
                }
            });

            $("#tags").html('<i class="fa fa-tags"></i> ' + tags.map(function(tag) {
                return '<a href="'+baseUrl+'tag/'+tag+'">'+tag+'</a>';
            }).join(", "));


            var id = $("#content").attr("data-post-id");
            var title = $("#content").find("h3:eq(0)").text();
            var description = $("#content").find("div#description").html().trim();

            ajaxThis("Admin/New_post/editPost", {'id': id, 'title': title, 'description' : description, 'category' : categoryId, 'tags' : tags.join(",")});
        }
    });
});