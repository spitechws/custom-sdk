function prepareMessage(response) {
    var html = '';
    if (response.success) {
        html += '<div class="alert alert-success">' + response.message + '</div>';
    } else {
        html += '<div class="alert alert-danger">' + response.message + '</div>';
    }
    return html;
}

function changePassword(form_id) {
    var apiURL = BASE_URL + 'admin/change_password';
    let form_data = $('#' + form_id).serialize();
    $.ajax({
        url: apiURL,
        data: form_data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'POST',
        success: function (response) {
            $('#' + form_id + '_message').html(prepareMessage(response));
            if (response.success) {
                $('#' + form_id)[0].reset();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown)
        }
    });
}

function loadSubcategory(category_id, container_id) {
    var apiURL = BASE_URL + 'ajax/sub_category';
    $.ajax({
        url: apiURL,
        data: {
            category_id: category_id
        },
        dataType: 'json',
        contentType: 'json',
        method: 'GET',
        success: function (response) {
            var html = '<option value="">- Select -</option>';
            if (response.success) {
                $.each(response.data, function (key, val) {
                    html += '<option value="' + val.id + '">' + val.sub_category + '</option>';
                });
            }
            $('#' + container_id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}

function loadDepartment(industry_id, container_id) {
    var apiURL = BASE_URL + 'ajax/department-list';
    $.ajax({
        url: apiURL,
        data: {
            industry_id: industry_id
        },
        dataType: 'json',
        contentType: 'json',
        method: 'GET',
        success: function (response) {
            var html = '<option value="">- Select -</option>';
            if (response.success) {
                $.each(response.data, function (key, val) {
                    html += '<option value="' + val.id + '">' + val.department_name + '</option>';
                });
            }
            $('#' + container_id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}

function loadFunctions(department_id, container_id) {
    var apiURL = BASE_URL + 'ajax/function-list';
    $.ajax({
        url: apiURL,
        data: {
            department_id: department_id
        },
        dataType: 'json',
        contentType: 'json',
        method: 'GET',
        success: function (response) {
            var html = '<option value="">- Select -</option>';
            if (response.success) {
                $.each(response.data, function (key, val) {
                    html += '<option value="' + val.id + '">' + val.function_name + '</option>';
                });
            }
            $('#' + container_id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}



function loadBannerRelatedTo(related_to, container_id) {
    var apiURL = BASE_URL + 'ajax/banner_related_to';
    $.ajax({
        url: apiURL,
        data: {
            related_to: related_to
        },
        dataType: 'json',
        contentType: 'json',
        method: 'GET',
        success: function (response) {
            var html = '<option value="">- Select -</option>';
            if (response.success) {
                $.each(response.data, function (key, val) {
                    html += '<option value="' + val.id + '">' + val.name + '</option>';
                });
            }
            $('#' + container_id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}

function getState(country_id, container_id) {
    var apiURL = BASE_URL + 'ajax/state';
    $.ajax({
        url: apiURL,
        data: {
            country_id: country_id
        },
        dataType: 'json',
        contentType: 'json',
        method: 'GET',
        success: function (response) {
            var html = '<option value="">- Select -</option>';
            if (response.success) {
                $.each(response.data, function (key, val) {
                    html += '<option value="' + val.id + '">' + val.state_name + '</option>';
                });
            }
            $('#' + container_id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}

function getCity(state_id, container_id) {
    var apiURL = BASE_URL + 'ajax/city';
    $.ajax({
        url: apiURL,
        data: {
            state_id: state_id
        },
        dataType: 'json',
        contentType: 'json',
        method: 'GET',
        success: function (response) {
            var html = '<option value="">- Select -</option>';
            if (response.success) {
                $.each(response.data, function (key, val) {
                    html += '<option value="' + val.id + '">' + val.city_name + '</option>';
                });
            }
            $('#' + container_id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}


function showPassword(passwordEye_id, password_id) {
    var password = $("#" + password_id);
    var passwordEye = $('#' + passwordEye_id);
    var type = password.attr("type");
    console.log(type);
    if (type == "password") {
        $(passwordEye).removeClass("bi-eye-slash");
        $(passwordEye).addClass("bi-eye");
        password.attr("type", "text");
    } else if (type == "text") {
        $(passwordEye).removeClass("bi-eye");
        $(passwordEye).addClass("bi-eye-slash");
        password.attr("type", "password");
    }
}

function prepareMessage(response) {
    var html = '';
    if (response.success) {
        html += '<div class="alert alert-success">' + response.data + '</div>';
    } else {
        html += '<div class="alert alert-danger">' + response.data + '</div>';
    }
    return html;
}

function subscribe(form_id) {
    let apiURL = BASE_URL + 'ajax/subscribe';
    let form_data = $('#' + form_id).serialize();
    $.ajax({
        url: apiURL,
        data: form_data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //dataType: 'json',
        // contentType: 'json',
        method: 'POST',
        success: function (response) {
            $('#' + form_id + '_message').html(prepareMessage(response));
            if (response.success) {
                $('#' + form_id)[0].reset();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}




function saveCourseModule(form_id, model_id) {
    let apiURL = BASE_URL + 'ajax/course_module_save';
    let form_data = $('#' + form_id).serialize();
    $.ajax({
        url: apiURL,
        data: form_data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'POST',
        success: function (response) {
            $('#' + form_id + '_message').html(prepareMessage(response));
            if (response.success) {
                $('#' + form_id)[0].reset();
                $("#" + model_id).modal('hide');
                location.reload(true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}

function saveModuleSection(form_id, model_id) {
    let apiURL = BASE_URL + 'ajax/module_section_save';
    let form_data = $('#' + form_id).serialize();
    $.ajax({
        url: apiURL,
        data: form_data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'POST',
        success: function (response) {
            $('#' + form_id + '_message').html(prepareMessage(response));
            if (response.success) {
                $('#' + form_id)[0].reset();
                $("#" + model_id).modal('hide');
                location.reload(true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // alert(errorThrown)
        }
    });
}

function saveSectionTopic(form_id, model_id) {
    let apiURL = BASE_URL + 'ajax/section_topic_save';
    let form_data = $('#' + form_id).serialize();
    $.ajax({
        url: apiURL,
        data: form_data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'POST',
        success: function (response) {
            $('#' + form_id + '_message').html(prepareMessage(response));
            if (response.success) {
                $('#' + form_id)[0].reset();
                $("#" + model_id).modal('hide');
                location.reload(true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert(errorThrown)
        }
    });
}