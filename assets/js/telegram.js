/**
 * Created by kozhevnikov on 02.08.2016.
 */
$(document).ready(function () {
    var messageInput,
        chatFlow,
        updater;

    var isInitiated = false;
    $(document).on('click', '#tlgrm-init-btn', function (e) {
        var that = $(this);
        if (isInitiated) return false;
        isInitiated = true;
        $.ajax({
            type: 'post',
            url: telegramOptions.initChat,
            dataType: 'html',
            success: function success(data) {
                that.replaceWith(data);
                messageInput = $('#tlgrm-chat-msg');
                chatFlow = $('#tlgrm-chat-flow');
                chatFlow.niceScroll({cursorcolor:"#999", cursorwidth: "5px"});
                getAllMessages();
            },
            error: function error(xhr, textStatus, errorThrown) {
                console.log(xhr);
            }
        });
    });

    $(document).on('click', '#tlgrm-close-btn', function (e) {
        clearInterval(updater);
        $.ajax({
            type: 'post',
            url: telegramOptions.destroyChat,
            dataType: 'html',
            success: function success(data) {
                $('#tlgrm-chat').replaceWith(data);
                isInitiated = false;
            },
            error: function error(xhr, textStatus, errorThrown) {
                console.log(xhr);
            }
        });
    });

    $(document).on('submit', '#tlgrm-chat-form', function (e) {
        e.preventDefault();
        $.ajax({
            type: this.getAttribute('method'),
            url: this.getAttribute('action'),
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function () {
                messageInput.val('');
            },
            success: function success(response) {
                appendOutgoing(response);
                chatFlow.animate({scrollTop: chatFlow[0].scrollHeight}, "slow");
            },
            error: function error(xhr, textStatus, errorThrown) {
                console.log(xhr);
            }
        });
    });
    $(document).on('keydown', '#tlgrm-chat-msg', function (e) {
        var code = e.keyCode || e.charCode;
        if (code == 13) {
            if (messageInput.val() == "") return false;
            $('#tlgrm-chat-form').submit();
            return false;
        }
    });
    function getAllMessages() {
        $.ajax({
            type: 'post',
            url: telegramOptions.getAllMessages,
            data: {},
            dataType: 'json',
            success: function success(data) {
                if (data.length > 0) {
                    $.each(data, function (index, element) {
                        element.direction == 1 ?
                            appendIncoming(element) :
                            appendOutgoing(element);
                    });
                } else {
                    appendIncoming({time: "0000-00-00", message: telegramOptions.initialMessage});
                }
                chatFlow.animate({scrollTop: chatFlow[0].scrollHeight}, "slow");
                getUpdates();
            },
            error: function error(xhr, textStatus, errorThrown) {
                console.log(xhr);
            }
        });
    }

    function getUpdates() {
        updater = setInterval(function () {
            var lastMsg = $('.tlgrm-msg:last');
            $.ajax({
                type: 'post',
                url: telegramOptions.getLastMessages,
                data: {lastMsgTime: lastMsg.attr('data-time') || null},
                dataType: 'json',
                beforeSend: function () {
                },
                success: function success(response) {
                    if (response) {
                        $.each(response, function (index, element) {
                            if (element.direction == 1)
                                appendIncoming(element)
                        });
                        chatFlow.animate({scrollTop: chatFlow[0].scrollHeight}, "slow");
                    }
                },
                error: function error(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                }
            });
        }, 10000);
    }

    function appendIncoming(data) {
        var msg = '<p class="tlgrm-msg tlgrm-incoming" data-time="' + data.time + '">' + data.message + '</p>';
        chatFlow.append(msg);

    }

    function appendOutgoing(data) {
        var msg = '<p class="tlgrm-msg tlgrm-outgoing" data-time="' + data.time + '">' + data.message + '</p>';
        chatFlow.append(msg);
    }

});