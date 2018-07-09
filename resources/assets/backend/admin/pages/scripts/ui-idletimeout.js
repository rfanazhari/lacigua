var UIIdleTimeout = function () {
    return {
        init: function () {
            var $countdown;

            $('body').append(
                '<div class="modal fade" id="idle-timeout-dialog" data-backdrop="static">' +
                '<div class="modal-dialog modal-small"><div class="modal-content">' +
                '<div class="modal-header"><h4 class="modal-title">' + $('#sessiontitle').val() + '</h4></div>' +
                    '<div class="modal-body">' + 
                        '<p><i class="fa fa-warning"></i> ' + $('#sessionwarning').val() + '</p>' +
                        '<p>' + $('#sessionquestion').val() + '</p>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                        '<button id="idle-timeout-dialog-logout" type="button" class="btn btn-default">' + $('#sessionno').val() + '</button>' +
                        '<button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-primary" data-dismiss="modal">' +
                            $('#sessionyes').val() + 
                        '</button>' +
                    '</div>' +
                '</div></div></div>');

            $.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
                idleAfter: $("[name='autolock']").val() / 1000,
                timeout: 30000, //30 seconds to timeout
                pollingInterval: $("[name='autolock']").val() / 1000,
                keepAliveURL: 'demo/idletimeout_keepalive.php',
                serverResponseEquals: 'OK',
                onTimeout: function(){
                    window.location = $("[name='basesite']").val() + $("[name='adminpage']").val() + 'lock';
                },
                onIdle: function(){
                    $('#idle-timeout-dialog').modal('show');
                    $countdown = $('#idle-timeout-counter');

                    $('#idle-timeout-dialog-keepalive').on('click', function () { 
                        $('#idle-timeout-dialog').modal('hide');
                    });

                    $('#idle-timeout-dialog-logout').on('click', function () { 
                        $('#idle-timeout-dialog').modal('hide');
                        $.idleTimeout.options.onTimeout.call(this);
                    });
                },
                onCountdown: function(counter){
                    $countdown.html(counter);
                }
            });
        }
    };
}();