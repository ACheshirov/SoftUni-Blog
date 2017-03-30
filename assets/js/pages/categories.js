var Categories = new function() {
    this.add = function() {
        var name = prompt(lang['categoryNamePrompt'] + ":");

        if (name !== null && name.trim().length > 0) {
            ajaxThis("Admin/categories/add", {'name' : name}, function(id) {
                var tr = $('<tr/>');
                tr.attr('id', 'categoryId_' + id);
                tr.append("<td>" + name + "</td>");
                tr.append('<td>[<a href="#" data-type="edit">'+lang['categoryLinkEdit']+'</a>] [<a href="#" data-type="delete">'+lang['categoryLinkDelete']+'</a>]</td>');
                tr.css("opacity", 0);

                $("#categoriesTbody").append(tr);

                tr.animate({"opacity" : 1}, 500);
            });
        }
    }

    this.edit = function(id, oldName) {
        var newName = prompt(lang['categoryNamePrompt'] + ":", oldName);
        if (newName !== null && newName.trim().length > 0) {
            ajaxThis("Admin/categories/edit", {'id': id, 'name': newName}, function () {
                $('td:eq(0)', '#categoryId_' + id).text(newName);
            });
        }
    }

    this.delete = function(id) {
        if (confirm(lang['categoryConfirmDelete'])) {
            ajaxThis("Admin/categories/delete", {'id': id}, function () {
                $('#categoryId_' + id).animate({
                    'opacity' : 0
                }, 500, function() {
                    $(this).remove();
                });
            });
        }
    }

    this.init = function() {
        $(document).ready(function() {
            $("#categoriesTbody").on("click", "a", function() {
                if ($(this).attr("data-type") !== undefined) {
                    var id = parseInt($(this).parent().parent().attr("id").split("_")[1]);
                    var oldName = $(this).parent().parent().find("td:eq(0)").text();

                    if ($(this).attr("data-type") == "edit")
                        Categories.edit(id, oldName);
                    else if ($(this).attr("data-type") == "delete")
                        Categories.delete(id);
                }
            });
        });
    }
};

Categories.init();