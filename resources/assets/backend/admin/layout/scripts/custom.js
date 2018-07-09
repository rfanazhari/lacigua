jQuery(document).ready(function() {
    Metronic.init();
    Layout.init();
    QuickSidebar.init();
    Demo.init();
    ComponentsDropdowns.init();
    ComponentsPickers.init();
    ComponentsFormTools.init();
    if ($("[name='autolock']").val() > 0) {
        UIIdleTimeout.init();
    }
    $('#someid').on('click', function() {
        $('#OverviewcollapseButton').removeClass("collapse").addClass("expand");
        $('#PaymentOverview').hide();
    });
    $('#buttondel').click(function() {
        if (!$(this).find('#del').is(':checked')) {
            $('.checker').find('span').addClass('checked');
            $('[name="delete[]"]').prop('checked', true);
        } else {
            $('.checker').find('span').removeClass('checked');
            $('[name="delete[]"]').prop('checked', false);
        }
    });
    $('#buttonsel').click(function() {
        if (!$(this).find('#sel').is(':checked')) {
            $('.checker').find('span').addClass('checked');
            $('[name="selectdata[]"]').prop('checked', true);
        } else {
            $('.checker').find('span').removeClass('checked');
            $('[name="selectdata[]"]').prop('checked', false);
        }
    });
    $('#alertcon').click(function() {
        var data = $('[name="delete[]"]').serialize();
        if (data == '') {
            bootbox.alert($('#alertcon').attr('rel'));
        } else {
            bootbox.confirm($('#alertcon').attr('value'), function(result) {
                if (result) {
                    var form = $('#alertcon').closest('form')[0];
                    form.action = form.action + '/' + $('#alertcon').attr('data');
                    $('#delete').click();
                }
            });
        }
    });
    $('#selectpopup').click(function() {
        var data = $('[name="selectdata[]"]').serialize();
        if (data == '') {
            bootbox.alert($('#selectpopup').attr('rel'));
        } else {
            $('#selectfinishpopup').click();
        }
    });
    if ($("[name='searchby_']").val()) searchbyaction();
    $('.numberonly').numberOnly();
    $('.IsActive').IsActive();
    $('.Approve').Approve();
    $('.SetOnHeader').SetOnHeader();
    $('.SetOnSubHeader').SetOnSubHeader();
    $('.HolidayMode').HolidayMode();
    $('.ShowTime').ShowTime();
    $('.ChangeStatusPaid').ChangeStatusPaid();
    $('.ChangeStatusShipment').ChangeStatusShipment();
    $(".datetime").attr('readonly', true)
        .datetimepicker({
            isRTL: Metronic.isRTL(),
            format: "dd MM yyyy hh:ii",
            autoclose: true,
        });
    $(".datetimeoneminute").attr('readonly', true)
        .datetimepicker({
            isRTL: Metronic.isRTL(),
            format: "dd MM yyyy hh:ii",
            autoclose: true,
            minuteStep: 1
        });
    $(".dateonly").attr('readonly', true)
        .datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true,
            format: 'dd MM yyyy',
        });
    $(".monthonly").attr('readonly', true)
        .datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true,
            minViewMode: "months",
            format: 'MM',
        });
    $(".yearonly").attr('readonly', true)
        .datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true,
            minViewMode: "years",
            format: 'yyyy',
        });

    if ($("[name='action']").val() == 'detail') {
        disableall();
    }
    $("#scroll").attr('style', "width:" + (100 - ((($.trim($("#langsize").val()) / $(window).width()) * 100) + ((200 / $(window).width()) * 100))) + "%;");
    $("#scroll").removeClass("hide");
    $("#scroll").mCustomScrollbar({
        axis: "x",
        theme: "dark-thin",
        autoExpandScrollbar: true,
        advanced: { autoExpandHorizontalScroll: true }
    });
    $("#mCSB_1_scrollbar_horizontal").attr('style', 'height:auto;');
    $("#scroll").mCustomScrollbar("scrollTo", "#selectscroll");

    $('span[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        html: true
    });
});

$(window).resize(function() {
    $("#scroll").attr('style', "width:" + (100 - ((($.trim($("#langsize").val()) / $(window).width()) * 100) + ((200 / $(window).width()) * 100))) + "%;");
})
$.fn.IsActive = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' IsActive ')[1].split(' ')[0];
                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "setactive", 'value': value },
                        success: function(data) {
                            if (data == 'OK') {
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.Approve = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' Approve ')[1].split(' ')[0];
                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "setapprove", 'value': value },
                        success: function(data) {
                            if (data == 'OK') {
                                thisswitch.parent().parent().parent().prev('td').text(data['data']);
                                thisswitch.attr('disabled', true);
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                                thisswitch.bootstrapSwitch('toggleDisabled', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.SetOnHeader = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' SetOnHeader ')[1].split(' ')[0];

                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "setonheader", 'value': value },
                        success: function(data) {
                            if (data == 'OK') {
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.SetOnSubHeader = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' SetOnSubHeader ')[1].split(' ')[0];

                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "setonsubheader", 'value': value },
                        success: function(data) {
                            if (data == 'OK') {
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.HolidayMode = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' HolidayMode ')[1].split(' ')[0];

                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "setholidaymode", 'value': value },
                        success: function(data) {
                            if (data == 'OK') {
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.ShowTime = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' ShowTime ')[1].split(' ')[0];

                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "showtime", 'value': value },
                        success: function(data) {
                            if (data == 'OK') {
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.ChangeStatusPaid = function() {
    $(this).each(function() {
        $(this).on('switchChange.bootstrapSwitch', function(event, state) {
            var thisswitch = $(this);
            thisswitch.bootstrapSwitch('state', !state, true);
            bootbox.confirm($(this).attr('rel'), function(result) {
                if (result) {
                    var value = thisswitch.attr('class').split(' ChangeStatusPaid ')[1].split(' ')[0];
                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "ChangeStatusPaid", 'value': value },
                        success: function(data) {
                            var data = JSON.parse(data);

                            if (data['response'] == 'OK') {
                                thisswitch.parent().parent().parent().prev('td').text(data['data']);
                                thisswitch.attr('disabled', true);
                                thisswitch.bootstrapSwitch('toggleState', true, true);
                                thisswitch.bootstrapSwitch('toggleDisabled', true, true);
                            } else {
                                bootbox.alert(data);
                            }
                        }
                    });
                }
            });
        });
    });
};
$.fn.ChangeStatusShipment = function(nextfunction) {
    $(this).each(function() {
        var prevval;
        $(this).focus(function() {
            prevval = $(this).val();
        }).change(function() {
            $(this).blur();
            var StatusShipment = $(this).val();
            var thisswitch = $(this);
            bootbox.confirm($(this).attr('rel'), function(result) {
                var ID = thisswitch.attr('class').split(' ChangeStatusShipment ')[1].split(' ')[0];
                if (result) {
                    $.ajax({
                        url: $("#defaultview").attr('action') + '/ajaxpost',
                        type: 'POST',
                        data: { 'ajaxpost': "ChangeStatusShipment", 'ID': ID, 'StatusShipment': StatusShipment },
                        success: function(data) {
                            var data = JSON.parse(data);

                            if (data['response'] == 'OK') {
                                if (StatusShipment == 2) {
                                    thisswitch.parent().prev('td').text(data['data']['AWBNumber']);
                                    thisswitch.parent().text(data['data']['StatusShipment']);
                                } else {
                                    thisswitch.find("option[value='" + (StatusShipment - 1) + "']").remove();
                                    thisswitch.find('option[value="' + StatusShipment + '"]').attr('selected', true);
                                }
                                if (typeof nextfunction === "function") { nextfunction(); }
                            } else {
                                thisswitch.find('option[value="' + prevval + '"]').attr('selected', true);
                            }
                        }
                    });
                } else {
                    thisswitch.find('option[value="' + prevval + '"]').attr('selected', true);
                }
            });
        });
    });
};
$.fn.numberOnly = function() {
    return this.each(function() {
        $(this).keydown(function(e) {
            var key = e.charCode || e.keyCode || 0;
            return (key == 8 || key == 9 || key == 13 || key == 46 || key == 110 || key == 190 || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
        });
    });
};

function searchbyaction() {
    if ($("[name='searchby_']").find("option:selected").attr("value").indexOf("date") != -1) {
        var fordatelastval = $("#fordatelastval").val();
        $("#fordatelast").addClass("col-md-3 marlm15");
        $("#fordatelast").html(
            "<div class='input-group'>" +
            "<input class='input-sm form-control col-md-3 hover' type='text' name='searchlast_' value='" + fordatelastval + "'/>" +
            "<span class='input-group-btn' onclick='$(this).parent().find(\"input\").val(\"\");'>" +
            "<button class='btn btn-sm default date-range-toggle' type='button'><i class='fa fa-refresh'></i></button>" +
            "</span>" +
            "</div>"
        );
        $("[name='search_'],[name='searchlast_']").attr('readonly', true)
            .datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                format: 'dd MM yyyy'
            });
        $("[name='search_']")
            .attr('placeholder', $("#inputdate1").val() + '...')
            .wrap("<div class='input-group'></div>")
            .after(
                "<span class='input-group-btn' onclick='$(this).parent().find(\"input\").val(\"\");'>" +
                "<button class='btn btn-sm default date-range-toggle' type='button'><i class='fa fa-refresh'></i></button>" +
                "</span>"
            );;
        $("[name='search_']").addClass('hover');
        $("[name='searchlast_']").attr('placeholder', $("#inputdate2").val() + '...');
    }
}

function searchbychange() {
    if ($("[name='searchby_']").find("option:selected").attr("value").indexOf("date") != -1) {
        $("#fordatelast").addClass("col-md-3 marlm15");
        $("#fordatelast").html(
            "<div class='input-group'>" +
            "<input class='input-sm form-control col-md-3 hover' type='text' name='searchlast_' value=''/>" +
            "<span class='input-group-btn' onclick='$(this).parent().find(\"input\").val(\"\");'>" +
            "<button class='btn btn-sm default date-range-toggle' type='button'><i class='fa fa-refresh'></i></button>" +
            "</span>" +
            "</div>"
        );
        $("[name='search_'],[name='searchlast_']").attr('readonly', true)
            .val('')
            .datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                format: 'dd MM yyyy'
            });
        var span = $("[name='search_']").parent().find('span');
        if (!span.length)
            $("[name='search_']")
            .attr('placeholder', $("#inputdate1").val() + '...')
            .wrap("<div class='input-group'></div>")
            .after(
                "<span class='input-group-btn' onclick='$(this).parent().find(\"input\").val(\"\");'>" +
                "<button class='btn btn-sm default date-range-toggle' type='button'><i class='fa fa-refresh'></i></button>" +
                "</span>"
            );
        $("[name='search_']").addClass('hover');
        $("[name='searchlast_']").attr('placeholder', $("#inputdate2").val() + '...');
    } else {
        $("[name='search_'],[name='searchlast_']").attr({
            'readonly': false,
            'placeholder': $("#inputsearch").val() + '...',
        }).val('').datepicker('remove');
        $("#fordatelast").removeClass("col-md-3 marlm15");
        $("#fordatelast").empty();
        if ($("[name='search_']").parent().html().indexOf("</div>") != -1 || $("[name='search_']").parent().html().indexOf("</span>") != -1) {
            $("[name='search_']").removeClass('hover');
            $("[name='search_']").unwrap();
            $('#fordatefirst').find('span').remove();
        }
    }
}

function disableall() {
    $('form').find('fieldset').closest('form').find('input, textarea, button, select').attr('disabled', 'disabled');
    $('form').find('fieldset').closest('form').find('button').last().after(' <span class="red">Can\'t change this transaction, because you request page for view detail !</span>');
    $("a[id^='delete']").attr('disabled', 'disabled');
}

function deleteSinglePopup(callback, callbackid, removelinked) {
    $('#' + callback).html('');
    $('[name="' + callbackid + '"]').val('');
    $('#' + removelinked).hide();
}

function popup(url, type, id, callback, callbackid, removelinked = '') {
    bootbox.dialog({
        title: "Please Wait !",
        message: '<div class="progress progress-striped active">' +
            '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>' +
            '</div>',
    });
    $('.modal-dialog').attr('class', 'modal-dialog modal-lg');

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('.bootbox-close-button').click();
        }
    });

    var popuptype = "type_" + type;
    var popupid = "id_" + id;
    var popupurl = url + popupid + "/" + popuptype;

    $('.modal-content').append('<iframe id="iframe" src="' + popupurl + '" name="main" frameborder="0" style="overflow:scroll; height:100%; width:100%; display:none;" height="100%" width="100%"/></iframe>');

    $("#iframe").on("load", function() {
        $('.modal-content').append("<button type='button' class='bootbox-close-button close hide'>×</button>");
        $(".modal-header").remove();
        $(".modal-body").remove();

        $("#iframe").contents().find(".page-bar").append("<ul class='page-breadcrumb' style='float:right;'><li class='fwbold hover'><button id='modalclose' type='button' class='bootbox-close-button close'>×</button></li></ul>");
        $("#iframe").contents().find("#modalclose").click(function() {
            $('.bootbox-close-button').click();
        });
        if (type == "single") {
            $("#iframe").contents().find("tbody").find("tr").click(function() {
                $('#' + callback).html($(this).find("td").next().html() + ' - ' + $(this).find("td").next().next().html());
                $('[name="' + callbackid + '"]').val($(this).find("td").first().html());
                if (removelinked) {
                    $('#' + removelinked).removeClass('hide');
                }
                $('.bootbox-close-button').click();
            });
        } else {
            $("#iframe").contents().find("#selectfinishpopup").click(function() {
                $.each($("#iframe").contents().find('[name="selectdata[]"]').serializeArray(), function(index, data) {
                    alert(data.value);
                });
            });
        }
        $(".modal-content").attr("style", "padding:10px; height:580px;");
        $("#iframe").show();
    });
}

function deleteMultiplePopup(id) {
    $('#' + id).remove();
}

function popupmultiple(url, type, id, callback, idnew) {
    bootbox.dialog({
        title: "Please Wait !",
        message: '<div class="progress progress-striped active">' +
            '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>' +
            '</div>',
    });
    $('.modal-dialog').attr('class', 'modal-dialog modal-lg');

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('.bootbox-close-button').click();
        }
    });

    var popuptype = "type_" + type;
    var popupid = "id_" + id;
    var popupurl = url + popupid + "/" + popuptype;

    $('.modal-content').append('<iframe id="iframe" src="' + popupurl + '" name="main" frameborder="0" style="overflow:scroll; height:100%; width:100%; display:none;" height="100%" width="100%"/></iframe>');

    $("#iframe").on("load", function() {
        $('.modal-content').append("<button type='button' class='bootbox-close-button close hide'>×</button>");
        $(".modal-header").remove();
        $(".modal-body").remove();

        $("#iframe").contents().find(".page-bar").append("<ul class='page-breadcrumb' style='float:right;'><li class='fwbold hover'><button id='modalclose' type='button' class='bootbox-close-button close'>×</button></li></ul>");
        $("#iframe").contents().find("#modalclose").click(function() {
            $('.bootbox-close-button').click();
        });

        if (type == "single") {
            $("#iframe").contents().find("tbody").find("tr").click(function() {
                var iditem = $(this).find("td").first().html() + '-' + $(this).find("td").next().html();

                var check = false;
                var response = '';
                $("input[name^='" + idnew + "']").each(function() {
                    var tmpiditem = iditem.split('-');
                    var tmpval = $(this).val().split('-');
                    if (tmpiditem[0] == tmpval[0]) {
                        check = true;
                        response = 'Size Already !';
                    } else if (tmpiditem[1] == tmpval[1]) {
                        check = true;
                        response = 'Group Size Already !';
                    }
                });

                $('.bootbox-close-button').click();

                if (!check) {
                    var hidedata = '<input type="text" class="form-control input-sm hide" name="' + idnew + '[]" value="' + iditem + '">';
                    var td = '<td width="30px">' + hidedata + '<button type="button" class="btn2 btn2-sm default green-stripe" style="height:30px; color:black;" onclick="deleteMultiplePopup(\'' + iditem + '\')"><i class="fa fa-times"></i></button></td>';
                    $('#' + callback).append('<tr id="' + iditem + '">' + td + $(this).html() + '</tr>');
                } else {
                    bootbox.alert(response);
                }
            });
        }

        $(".modal-content").attr("style", "padding:10px; height:580px;");
        $("#iframe").show();
    });
}

function popuphistory(url, id, patientid, hospitalid) {
    bootbox.dialog({
        title: "Please Wait !",
        message: '<div class="progress progress-striped active">' +
            '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>' +
            '</div>',
    });
    $('.modal-dialog').attr('class', 'modal-dialog').attr("style", "width:" + ($(window).width() * 0.9) + "px;");

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('.bootbox-close-button').click();
        }
    });

    var popupurl = url + "id_" + id;
    popupurl += "/patientid_" + patientid;
    popupurl += "/hospitalid_" + hospitalid;

    $('.modal-content').append('<iframe id="iframe" src="' + popupurl + '" name="main" frameborder="0" style="overflow:scroll; height:100%; width:100%; display:none;" height="100%" width="100%"/></iframe>');

    $("#iframe").on("load", function() {
        $('.modal-content').append("<button type='button' class='bootbox-close-button close hide'>×</button>");
        $(".modal-header").remove();
        $(".modal-body").remove();

        $("#iframe").contents().find(".page-bar").append("<ul class='page-breadcrumb' style='float:right;'><li class='fwbold hover'><button id='modalclose' type='button' class='bootbox-close-button close'>×</button></li></ul>");
        $("#iframe").contents().find("#modalclose").click(function() {
            $('.bootbox-close-button').click();
        });

        $(".modal-content").attr("style", "padding:10px; height:580px;");
        $("#iframe").show();
    });
}

function uniqid(a = "", b = false) {
    var c = Date.now() / 1000;
    var d = c.toString(16).split(".").join("");
    while (d.length < 14) {
        d += "0";
    }
    var e = "";
    if (b) {
        e = ".";
        var f = Math.round(Math.random() * 100000000);
        e += f;
    }
    return a + d + e;
}