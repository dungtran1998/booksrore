$(document).ready(function () {
    let tableForm = $('#table-form');
    var param = new URLSearchParams(window.location.search);
    $('.btn-delete').click(function (e) {
        e.preventDefault();
        var link = $(this).attr('href');
        var confirmOBj = confirmObj("Bạn có chắc chắn muốn xoá dòng này?", "warning", "Có, Hãy Xoá");
        Swal.fire(confirmOBj).then(function (result) {
            if (result.value) {
                window.location.href = link;
            }
        })
    });

    $('input[name="cid[]"]').click(function (e) {
        let checkBoxes = $('input[name="cid[]"]:checked').length;
        if (checkBoxes > 0) {
            $(".navbar-badge").html(checkBoxes);
            $(".navbar-badge").css("display", "inline-block")
        } else {
            $(".navbar-badge").html("");
            $(".navbar-badge").css("display", "none")
        }
    })
    $('button[data-type]').click(function (e) {
        e.preventDefault();
        var type = $(this).attr("data-type");
        $(".input-type-hidden").val(type);
        $("#form-submit").submit();
    })

    $(".btn-search").click(function (e) {
        e.preventDefault()
        var searchBy = $("select[name='search_by']").val();
        var searchFilter = $("input[name='search']").val();
        var param = ["search_by", "search"];
        var link = createLink(param);
        link += "search_by=" + searchBy + "&search=" + searchFilter;
        window.location.href = link;
    })

    $('.btn-apply-bulk-action').click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href');

        let action = $('.slb-bulk-action').val();
        let countChecked = $('input[name="cid[]"]:checked').length;

        if (action) {
            if (countChecked > 0) {
                url = url.replace('value_new', action);
                confirmBulkAction(action, url);
            } else {
                showToast("warning", "bulk-action-not-selected-row");
            }
        } else {
            showToast("warning", "bulk-action-not-selected-action");
        }
    });

    $('#check-all-cid').change(function () {
        let checked = $(this).is(':checked');
        $('input[name="cid[]"').prop('checked', checked);
    });

    $("select.groupACP").change(function (e) {
        var value = $(this).val();
        $(".group-acp-hidden").val(value);
        var param = ["group_acp",];
        var link = createLink(param);
        link += "group_acp=" + value;
        $("#filter-bar").attr("action", link);
        window.location.href = link;
    });
    $(".slb-group-user").change(function (e) {
        // var idName = $(this).attr('id');
        var idVal = $(this).attr('data-id')
        var url = $('.group-name-hidden-' + idVal).val();
        url = url.replace('group_value', idVal);

        // console.log('#' + idName + ' + input[type="hidden"].group-name-hidden');
        var ele = '#group-name-' + idVal;
        $.get({
            url,
            success: function (data) {
                var dataObj = JSON.parse(data);

                if (dataObj.status) {
                    $(ele).notify(
                        "Change Success", {
                        elementPosition: "top center",
                        autoHideDelay: 500,
                        className: 'success'
                    })
                }

            }
        }, 'json');
    })

});

function clearSearch(name) {
    $("input[name='" + name + "']").val("");
    $("select[name='search_by']").val("all");
    $("#filter-search").submit();
}

function changeStatus(link) {
    $.get(link, function (data) {
        console.log(data);
        var ele = "a#" + data[3] + "-" + data[0];
        var colorAdd_1 = "btn-success";
        var colorAdd_2 = "btn-danger";
        var iconAdd_1 = 'fa-check';
        var iconAdd_2 = 'fa-minus';
        if (data[1] == "active" || data[1] == "1") {
            colorAdd_1 = "btn-danger";
            colorAdd_2 = "btn-success";
            iconAdd_1 = 'fa-minus';
            iconAdd_2 = 'fa-check';
        }
        $(ele).attr("href", "javascript:changeStatus('" + data[2] + "')");
        $(ele).removeClass(colorAdd_1).addClass(colorAdd_2);
        $(ele + " i").removeClass(iconAdd_1).addClass(iconAdd_2);
        $("#itemTr-" + data[0] + " td:not(.info-user) p.mb-0:last-child").html('<i class="far fa-clock"></i> ' + data[4]);
        $(ele).notify(
            "Change Success", {
            elementPosition: "top center",
            autoHideDelay: 500,
            className: 'success',
        }
        );
    }, 'json')
}

function sortList(objectHTML, column, order) {
    $('input[name="filter_column"').val(column);
    $('input[name="filter_column_dir"').val(order);
    $('#table-form').submit();
    // console.log(objectHTML);
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function showToast(type, action) {
    let message = "";
    switch (action) {
        case "bulk-action-not-selected-action":
            message = "Vui lòng chọn action cần thực hiện"
            break;
        case "bulk-action-not-selected-row":
            message = "Vui lòng chọn ít nhất 1 dòng dữ liêu để thực hiện";
            break;
        case "bulk-action-active-success":
            message = "Bạn đã active thành công";
            break;
        case "bulk-action-delete-success":
            message = "Bạn đã xoá thành công";
            break;
        case "bulk-action-inactive-success":
            message = "Bạn đã inactive thành công";
            break;
        case "insert-success":
            message = "Bạn đã thêm thành công";
            break;
        case "insert-failed":
            message = "Bạn chưa thêm được thành công";
            break;
        case "update-success":
            message = "Bạn đã cập nhật thành công";
            break;
        case "update-failed":
            message = "Bạn chưa cập nhật thất bại";
            break;
    }
    Toast.fire({
        icon: type,
        title: message
    })
}

function confirmObj(text, icon, confirmText) {
    return {
        title: 'Bạn có chắc chắn ?',
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmText
    }
}

function confirmBulkAction(action, link) {
    let confirm = {};
    // let confirmButton = "";
    // let confirmText = "";
    // let confirmNotifyAction = "";
    switch (action) {
        case "multiDelete":
            confirm = confirmObj("Bạn có chắc chắn muốn xoá ?", "warning", "Yes, delete it");
            // confirmButton = "Delete!";
            // confirmText = "Your item has been delete";
            // confirmNotifyAction = "bulk-action-delete-success";
            break;
        case "multiActive":
            confirm = confirmObj("Bạn có chắc chắn muốn active ?", "warning", "Yes, active it");
            // confirmButton = "Active!";
            // confirmText = "Your item has been activate";
            // confirmNotifyAction = "bulk-action-active-success";
            break;
        case "multiInactive":
            confirm = confirmObj("Bạn có chắc chắn muốn inactive?", "warning", "Yes, inactive it");
            // confirmButton = "Inactive!";
            // confirmText = "Your item has been inactived";
            // confirmNotifyAction = "bulk-action-inactive-success";
            break;
        default:
            showToast("warning", "bulk-action-not-selected-action");
            return
    }
    Swal.fire(confirm).then(function (result) {
        if (result.value) {
            $('#table-form').attr('action', link);;
            $('#table-form').submit();
        }
    })
}

function createLink(exceptParams) {
    var param = new URLSearchParams(window.location.search);
    var searchParams = param.entries();
    var pathName = getDirName(window.location.pathname)

    var link = pathName + "?";
    for (var pair of searchParams) {
        if (exceptParams.indexOf(pair[0]) == -1) {
            link += pair[0] + "=" + pair[1] + "&";
        }
    }
    return link;
}

function getDirName(pathname) {
    var arr = pathname.split('/');
    return arr[arr.length - 1];
}