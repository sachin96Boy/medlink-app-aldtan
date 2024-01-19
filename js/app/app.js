$appSearchTimeOut = null;
$(function () {
    initAppLanguage();
    initTimeLogTimers();
    initSearchField();
    appContentHeight();
    allowedNumberOnly();
    disableAutocomplete();
    setCurrencyFormatOnInputValue();
});

function appContentHeight() {
    $windowHeight = $(window).height();
    $appHeaderHeight = 10;
    $appFooterHeight = 10;
    if ($('.app-header').length > 0) {
        $appHeaderHeight = $('.app-header').outerHeight();
    }
    if ($('.app-footer').length > 0) {
        $appFooterHeight = $('.app-footer').outerHeight();
    }

    $contentHeight = $windowHeight - ($appHeaderHeight + $appFooterHeight + 40);
    $('.app-content').height($contentHeight);

    $parentHeight = $('.app-content .app-content-main').height();
    $height = $parentHeight - 10;
    if ($height > $contentHeight) {
        $height = $contentHeight - 20;
    }
    $('.app-content .tab-pane > .app-content-main-save').height($height);

    $filterHeight = getDecimalValue($('.app-content .app-content-main .app-content-main-filters').height()) + 25;
    $mOffset = $('.app-content .app-content-main').position();
    $hOffset = $('.app-content .tab-pane > .app-content-main-history').position();
    if ($mOffset.top > 0 && $hOffset.top > 0 && $mOffset.top < $hOffset.top) {
        $filterHeight = $hOffset.top - $mOffset.top;
    }
    $height = $parentHeight - $filterHeight;
    if ($height > $contentHeight) {
        $height = $contentHeight - 20;
    }
    $('.app-content .tab-pane > .app-content-main-history').height($height);
}

function csrf_token() {
    return $('#_csrf_token').val();
}

function userId() {
    return $('#_user_id').val();
}

function userName() {
    return $('#_user_name').val();
}
function userCompany() {
    return $('#_user_company').val();
}

function userBusinessDetailId() {
    return $('#_user_business_id').val();
}

function userBusinessDetail() {
    return $('#_user_business_name').val();
}

function appMode() {
    return $('#_app_mode').val();
}

function initAppLanguage() {
    $('#h_language_form').validate({
        submitHandler: function ($form) {
            $.ajax({
                url: $($form).attr('action'),
                data: $($form).serialize(),
                method: $($form).attr('method'),
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {
                    $('#h_language').attr('disabled', true);
                },
                success: function ($data, $textStatus, $jqXHR) {
                    $('#h_language').attr('disabled', false);
                    if (typeUnd($data.Message) && $data.Message == 'Saved') {
                        window.location.href = window.location.href;
                    }
                },
                error: function ($jqXHR, $textStatus, $errorThrown) {
                    $('#h_language').attr('disabled', false);
                    if ($jqXHR.status == 401) {
                        sessionTimeOut($jqXHR.responseJSON);
                    }
                }
            });
        }
    });

    $('#h_language').change(function ($e) {
        $('#h_language_form').submit();
    });
}

function initTimeLogTimers() {
    $('#h_login_info_dropdown').on('show.bs.dropdown', function () {
        updateLatestTimeLogInfo();
    });
    startTimer();
    initTimeLogForms();
}

function startTimer() {
    updateTimeValue();
    clearInterval();
    setInterval(updateTimeValue, 1000);
}

function updateTimeValue() {
    $isClockIn = $('#h_time_log_is_clock_in').val();
    $clockInTime = $('#h_time_log_clocked_in_time').val();
    if ($isClockIn == 'yes') {
        var $currentTime = moment();
        var $startTime = moment($clockInTime);
        var $duration = moment.duration($currentTime.diff($startTime));
        $diff = moment($duration.hours() + ':' + $duration.minutes() + ':' + $duration.seconds(), "HH:mm:ss").format('HH:mm:ss');
        $('#h_time_log_timer').text($diff);
        $('#h_time_log_start_form').addClass('d-none').removeClass('d-block');
        $('#h_time_log_stop_form').addClass('d-block').removeClass('d-none');
    }
    else {
        $('#h_time_log_timer').text("00:00:00");
        $('#h_time_log_start_form').addClass('d-block').removeClass('d-none');
        $('#h_time_log_stop_form').addClass('d-none').removeClass('d-block');
    }
}

function updateLatestTimeLogInfo() {
    $.ajax({
        url: $('#h_time_log_timer').data('timer-url'),
        method: 'GET',
        dataType: 'json',
        beforeSend: function ($jqXHR, $obj) {

        },
        success: function ($data, $textStatus, $jqXHR) {
            updateTimeLogInfo($data);
        },
        error: function ($jqXHR, $textStatus, $errorThrown) {
            if ($jqXHR.status == 401) {
                sessionTimeOut($jqXHR.responseJSON);
            }
        }
    });
}

function updateTimeLogInfo($data) {
    if (typeUnd($data) && typeUnd($data.id) && $data.id > 0 && typeUnd($data.start_date) && typeUnd($data.start_time)) {
        $('#h_time_log_is_clock_in').val('yes');
        $clockInTime = moment($data.start_date + ' ' + $data.start_time, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
        $('#h_time_log_clocked_in_time').val($clockInTime);
    }
    else {
        $('#h_time_log_is_clock_in').val('no');
        $('#h_time_log_clocked_in_time').val('');
    }
    updateTimeValue();
}

function initTimeLogForms() {
    initStartTimeLogForm();
    initStopTimeLogForm();
}

function initStartTimeLogForm() {
    $('#h_time_log_start_form').validate({
        submitHandler: function ($form) {
            $('#h_time_log_start_date').val(moment().format('YYYY-MM-DD'));
            $('#h_time_log_start_time').val(moment().format('HH:mm:ss'));
            $.ajax({
                url: $($form).attr('action'),
                data: $($form).serialize(),
                method: $($form).attr('method'),
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {
                    addTimeLogStartingAnimation();
                },
                success: function ($data, $textStatus, $jqXHR) {
                    removeTimeLogStartingAnimation();
                    updateTimeLogInfo($data);
                },
                error: function ($jqXHR, $textStatus, $errorThrown) {
                    removeTimeLogStartingAnimation();
                    if ($jqXHR.status == 401) {
                        sessionTimeOut($jqXHR.responseJSON);
                    }
                }
            });
        }
    });
}

function initStopTimeLogForm() {
    $('#h_time_log_stop_form').validate({
        submitHandler: function ($form) {
            $('#h_time_log_finish_date').val(moment().format('YYYY-MM-DD'));
            $('#h_time_log_finish_time').val(moment().format('HH:mm:ss'));
            $.ajax({
                url: $($form).attr('action'),
                data: $($form).serialize(),
                method: $($form).attr('method'),
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {
                    addTimeLogStoppingAnimation();
                },
                success: function ($data, $textStatus, $jqXHR) {
                    removeTimeLogStoppingAnimation();
                    if (typeUnd($data.Message) && $data.Message == 'Success') {
                        updateTimeLogInfo();
                    }
                },
                error: function ($jqXHR, $textStatus, $errorThrown) {
                    removeTimeLogStoppingAnimation();
                    if ($jqXHR.status == 401) {
                        sessionTimeOut($jqXHR.responseJSON);
                    }
                }
            });
        }
    });
}

function addTimeLogStartingAnimation() {
    $('#h_time_log_start_form .btn').html('<span class="">' + local('Starting') + '...</span><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $('#h_time_log_start_form .btn').attr('disabled', true);
}

function removeTimeLogStartingAnimation() {
    $('#h_time_log_start_form .btn').html(local('Start'));
    $('#h_time_log_start_form .btn').attr('disabled', false);
}

function addTimeLogStoppingAnimation() {
    $('#h_time_log_stop_form .btn').html('<span class="">' + local('Stopping') + '...</span><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $('#h_time_log_stop_form .btn').attr('disabled', true);
}

function removeTimeLogStoppingAnimation() {
    $('#h_time_log_stop_form .btn').html(local('Stop'));
    $('#h_time_log_stop_form .btn').attr('disabled', false);
}

/*
* Advance Search
*/

function initSearchField() {
    var toastMsg = document.getElementById('app_search_dropdown_btn');
    if (toastMsg) {
        var dropdown = new bootstrap.Dropdown(toastMsg);
        if (dropdown) {
            $('#app_search_bar').on('input', function (e) {
                $keyword = $('#app_search_bar').val();
                if ($keyword == "") {
                    if ($('#app_search_dropdown_btn').hasClass('show')) {
                        dropdown.hide();
                    }
                }
                else {
                    if (!$('#app_search_dropdown_btn').hasClass('show')) {
                        dropdown.show();
                        $('#app_search_bar').focus();
                    }
                    searchNow();
                }
            });

            $('#app_search_dropdown').on('click', '.dropdown-item', function ($event) {
                dropdown.hide();
                $('#app_search_bar').val('');
            });
        }
    }
}

function searchNow() {
    $keyword = $('#app_search_bar').val();

    if ($appSearchTimeOut) {
        clearTimeout($appSearchTimeOut);
    }
    $appSearchTimeOut = setTimeout(function () {
        $.ajax({
            url: $('#app_search_bar').data('route'),
            data: {
                keyword_search: $keyword
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function ($jqXHR, $obj) {
                addAppSearchAnimation();
            },
            success: function ($data, $textStatus, $jqXHR) {
                removeAppSearchAnimation();
                updateSearchUi($data);
            },
            error: function ($jqXHR, $textStatus, $errorThrown) {
                if ($jqXHR.status == 401) {
                    sessionTimeOut($jqXHR.responseJSON);
                }
            }
        });
    }, 200);
}

function addAppSearchAnimation() {
    $('#app_search_dropdown').html('');
    $li = $("<li></li>").attr('id', 'app_search_dropdown_loading').append($('<div></div>').addClass('mt-3 mb-3').append($('<div></div>').addClass('d-flex justify-content-center').append($('<div></div>').addClass('spinner-border').attr('role', 'status').attr('aria-hidden', 'true'))));
    $('#app_search_dropdown').append($li);
}

function removeAppSearchAnimation() {
    $('#app_search_dropdown_loading').remove();
}

function updateSearchUi($data) {
    $('#app_search_dropdown').html('');
    $data.forEach($item => {
        $('<li></li>').append(
            $('<a></a>').attr('href', $item.route).attr('target', $item.target).addClass('dropdown-item border-radius-md').append(
                $('<div></div>').addClass('d-flex py-1').append(
                    $('<div></div>').addClass('d-flex flex-column justify-content-center').append(
                        $('<h6></h6>').addClass('text-sm font-weight-normal mb-0').text($item.screen)
                    ).append(
                        $('<p></p>').addClass('text-xs text-secondary mb-0').text($item.screen_category)
                    )
                )
            )
        ).appendTo($('#app_search_dropdown'));
    });
}

function allowedNumberOnly($class = '.number-only') {
    $(document).on('keypress change', $class, function ($event) {
        if (($event.which != 46 || $(this).val().indexOf('.') != -1) && ($event.which < 48 || $event.which > 57)) {
            $event.preventDefault();
        }
    });
    $(document).on('paste', $class, function ($event) {
        if ($event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
            $event.preventDefault();
        }
    });
}

function setCurrencyFormatOnInputValue($class = '.format-currency-input'){
    $(document).on('blur', $class, function($event){
        $value = getCurrencyValue(getDecimalValue($(this).val()));
        $(this).val($value);
    });
    $(document).on('focus', $class, function($event){
        $(this).select();
    });
}
