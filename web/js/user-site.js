function ajaxRequest(options, successCallback, errorCallback, beforeSendCallback) {

    if (!options.url) {
        throw new Error('URL is necessary.');
    }

    $.ajax({
        url: options.url,
        type: options.type ? options.type : 'GET',
        data: options.data ? options.data : {},
        dataType: options.dataType ? options.dataType : 'json',
        beforeSend: beforeSendCallback ? beforeSendCallback : '',
        success: successCallback ? successCallback : '',
        error: errorCallback ? errorCallback : ''
    });
}

function getUser(id) {
    ajaxRequest({ url: '/admin/users-sites/get-user', data: { id: id } }, function(data) {
        $('#user-username').html(data.username);
        $('#user-first_name').html(data.first_name);
        $('#user-last_name').html(data.last_name);
        $('#user-email').html(data.email);
        $('#usersiteform-user_id').val(data.id);
    });
}

function getService(id) {
    ajaxRequest({ url: '/admin/users-sites/get-service', data: { id: id } }, function(data) {
        $('#service-type').html(data.type);
        $('#usersiteform-service_id').val(data.id)
    });
}

function initUser() {
    var userId = $('#usersiteform-user_id').val();
    if (userId) {
        getUser(userId);
    }
}

function initService() {
    var serviceId = $('#usersiteform-service_id').val();
    if (serviceId) {
        getService(serviceId);
    }
}

$(function() {

    $('#search-user-input').autocomplete({
        serviceUrl: '/admin/users-sites/get-users',
        onSelect: function (suggestion) {
            getUser(suggestion.data);
        },
        transformResult: function(response) {
            var preparedResponse = JSON.parse(response);
            return {
                suggestions: $.map(preparedResponse, function(dataItem) {
                    var name = dataItem.first_name + ' ' + dataItem.last_name + ' (' + dataItem.username + ')';
                    return {
                        value: name,
                        data: dataItem.id
                    };
                })
            };
        }
    });

    $('#search-service-input').autocomplete({
        serviceUrl: '/admin/users-sites/get-services',
        onSelect: function (suggestion) {
            getService(suggestion.data);
        },
        transformResult: function(response) {
            var preparedResponse = JSON.parse(response);
            return {
                suggestions: $.map(preparedResponse, function(dataItem) {
                    return {
                        value: dataItem.type,
                        data: dataItem.id
                    };
                })
            };
        }
    });

    initUser();
    initService();
});
