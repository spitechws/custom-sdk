/*
 * define validatin key as title of element 
 * -> assign unique id to the element 
 * ->define one empty "span" tag with id="error_<id of element>"
 */
 function formValidateOnly(form_id) {
    var response = false;
    is_submit = true;
    submitform = true;
    formValidation(form_id, 'all');
    if (is_ajax_return) {
        if (submitform) {           
            response = true;
        }
    }
    return response;
}

function formValidate(form_id) {   
   
    is_submit = true;
    submitform = true;
    formValidation(form_id, 'all'); 
    formSubmit(form_id);
}

function formSubmit(form_id) {
    if (is_ajax_return) {
        if (submitform) {
             $('#' + form_id).submit();
        } else {
            return false;
        }
    } else {
        setTimeout(function () {
            do_form_submit(form_id);
        }, 1000);
    }
}

function isError(form_id,arg, status, msg) {
    //var element = document.getElementById(arg.id);
    // var errorContainer = document.getElementById('error_' + arg.id);

    var element=$('#' + form_id + ' #'+arg.id);
    var errorContainer = $('#' +form_id+' #error_'+arg.id);
    if (element != null) {
        if (status == 1) {
            //-------show error class------
            element.removeClass('has-success');
            element.addClass('has-error');
        } else {
            //----show succcess class-----------
            element.removeClass('has-error');
            element.addClass('has-success');
        }
        if (errorContainer != null) {
            if (msg != undefined) {
                errorContainer.html('<p style="color:red;">' + msg + '</p>');
            }else{
                errorContainer.html('');
            }
        } 
    } else {
        alert('Please define unique id in all the elements where validation is needed.');
        $(arg).focus();
    }
}

var submitform = true;
var is_submit = true;
var is_ajax_return = true;
function formValidation(form_id, name) {
    if (is_submit) {
        var $inputs = $('#' + form_id + ' :input,#' + form_id + ' textarea,#' + form_id + ' select');
        $inputs.each(function () {
            if ($(this).attr('validate') != undefined && !$(this).hasClass('hide')) {
                var validation = $(this).attr('validate');
                //var validation_array = validation.split(',');
                var validation_array = validation.split('||');
                var current_name = $(this).attr('name'); 
                //alert(current_name);
                for (var i = 0; i < validation_array.length; i++) {
                    var validation_inner_array = validation_array[i].split('|');
                    for (var j = 0; j < validation_inner_array.length; j++) {                        
                        switch (validation_inner_array[j])
                        {
                            case 'WordLimit' :
                                if (name == 'all' || current_name == name) {
                                    var value = $(this).val();
                                    if (value == '' || value == validation_inner_array[j + 1]) {
                                        submitform = false;
                                        isError(form_id,this, 1);
                                    } else {
                                        isError(form_id,this, 0);
                                    }
                                }
                                break;
                            case 'Required' :
                                if (name == 'all' || current_name == name) {
                                    var value = $(this).val();
                                    if (value == '' || value == validation_inner_array[j + 1]) {
                                        submitform = false;
                                        isError(form_id,this,1,"Required");
                                    } else {
                                        isError(form_id,this, 0);
                                    }
                                }
                                break;
                            case 'Rating' :
                                if (name == 'all' || current_name == name) {
                                    var value = $(this).val(); //alert(current_name);
                                    var radioValue = $("input:radio[name='" + current_name + "']:checked").val();
                                    if (radioValue === undefined) {                                       
                                        submitform = false;
                                        isError(form_id,this, 1,"Rating Required");
                                    } else {
                                        isError(form_id,this,0);
                                    }
                                }
                                break;
                            case 'Email' :
                                if (name == 'all' || current_name == name) {
                                    var value = $(this).val();
                                    var atpos = value.indexOf("@");
                                    var dotpos = value.lastIndexOf(".");
                                    if (value == '' || value == validation_inner_array[j + 1]) {                                        
                                        submitform = false;
                                        isError(form_id,this, 1,"Require valid email id");
                                    } else if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= value.length) {
                                        isError(form_id,this, 1,"Require valid email id");
                                        submitform = false;
                                    } else {
                                         isError(form_id,this,0);
                                    }
                                }
                                break;
                            case 'StrongPassword' :
                                if (name == 'all' || current_name == name) {
                                    var value = $(this).val();
                                    var passPatt = new RegExp("/((?=.*d)(?=.*[a-z])(?=.*[A-Z]).{8,15})/gm");
                                    //var res = patt.test(str);
                                    if (value == '' || value == validation_inner_array[j + 1]) {
                                        isError(form_id,this, 1,"Require strong password");
                                        submitform = false;
                                    } else if (!passPatt.test(value)) {
                                        isError(form_id,this, 1,"Require strong password");
                                        submitform = false;
                                    } else {
                                        isError(form_id,this,0);
                                    }
                                }
                                break;                            
                            case 'Mobile' :
                                if (name == 'all' || current_name == name) {
                                    var value = $(this).val();
                                    if (value == '' || value == validation_inner_array[j + 1]) {
                                        isError(form_id,this, 1,"Require valid mobile number");
                                        submitform = false;
                                    } else if (isNaN(value) || value.length != 10) {
                                       isError(form_id,this, 1,"Require valid mobile number");
                                        submitform = false;
                                    } else {
                                        isError(form_id,this,0);
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        });
    }
}






