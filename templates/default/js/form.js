function notEmpty(elemid, helperMsg) {
    elem = $('#' + elemid);
    if (elem.val().length == 0) {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    } else {
        valid(elemid);
        return true;
    }
}
function notEmpty1(elemid, helperMsg) {
    elem = $('#' + elemid);
    if (elem.val() == null) {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    } else {
        valid(elemid);
        return true;
    }
}
function notEmpty2(elemid, txt_default, helperMsg) {
    elem = $('#' + elemid);
    if (elem.val().length == 0) {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    } else if (elem.val() == txt_default) {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function notEmptyTextarea(elemid, helperMsg) {
    elem = $('#' + elemid);
    if (elem.val().length == 0) {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function isPhone(elemid, helperMsg) {
    elem = $('#' + elemid);
    var numericExpression = /^[0-9 .]+$/;
    if (elem.val().match(numericExpression)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}
function isPhone0(elemid, helperMsg) {
    elem = $('#' + elemid);
    // var numericExpression = /^[0-9 .+]+$/;
    var numericExpression =  /^0\d{9}$/;
    if (elem.val().match(numericExpression)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}
function notValue(elemid, helperMsg) {
    elem = $('#' + elemid);
    if (elem.val() == '0') {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function isUsername(elemid, helperMsg) {
    elem = $('#' + elemid);
    var strExp = /^[0-9a-zA-Z_-]+$/;
    if (elem.val().match(strExp)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}

function isNumeric(elemid, helperMsg) {
    elem = $('#' + elemid);
    var numericExpression = /^[0-9]+$/;
    if (elem.val().match(numericExpression)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    }
}

function isNumericList(elemid, helperMsg) {
    elem = $('#' + elemid);
    var numericExpression = /^[0-9; ]+$/;
    if (elem.val().match(numericExpression)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    }
}

function isAlphabet(elemid, helperMsg) {
    elem = $('#' + elemid);
    var alphaExp = /^[a-zA-Z]+$/;
    if (elem.val().match(alphaExp)) {
        return true;
    } else {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    }
}

function isAlphanumeric(elemid, helperMsg) {
    elem = $('#' + elemid);
    var alphaExp = /^[0-9a-zA-Z]+$/;
    if (elem.val().match(alphaExp)) {
        return true;
    } else {
        invalid(elemid, helperMsg);
        elem.focus();
        return false;
    }
}

function lengthRestriction(elemid, min, max) {
    elem = $('#' + elemid);
    var uInput = elem.val();
    if (uInput.length >= min && uInput.length <= max) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, 'Please enter between ' + min + ' and ' + max + ' characters');
        elem.focus();
        return false;
    }
}

function lengthMin(elemid, min, helperMsg) {
    elem = $('#' + elemid);
    var uInput = elem.val();
    if (uInput.length >= min) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}
// length max
function lengthMax(elemid, max, helperMsg) {
    elem = $('#' + elemid);
    var uInput = elem.val();
    if ((uInput.length <= max) || (uInput.length < max)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}
function madeSelection(elemid, helperMsg) {
    elem = $('#' + elemid);
    var i;
    for (i = 0; i < elem.options.length; i++) {
        if (elem.options[i].selected && (elem.options[i].value != "")) {
            return true;
        }
    }
    invalid(elemid, helperMsg);
    return false;
}

function madeCheckbox(elemid, helperMsg) {
    elem = $('#' + elemid);
    if (elem.is(':checked') == false) {
        alert(helperMsg);
        return false;
        invalid(elemid);
    } else {
        return true;
    }
}

function checkMultiCheckbox(containerid, helperMsg) {
    fields = $('#' + containerid).find('input:checked');
    length_checked = fields.length;
    if (!length_checked) {
        invalid(elemid, helperMsg);
        return false;
    }
    return true;
}

function emailValidator(elemid, helperMsg) {
    elem = $('#' + elemid);
    var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (elem.val().match(emailExp)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}

function checkMatchPass(helperMsg) {
    elem_value = $('#password').val();
    elem2_value = $('#re-password').val();
    if (elem_value != elem2_value) {
        invalid('re-password', helperMsg);
        return false;
    } else {
        valid('re-password');
        return true;
    }
}

function checkMatchPass_2(pass, repass, helperMsg) {
    elem_value = $('#' + pass).val();
    elem2_value = $('#' + repass).val();
    if (elem_value != elem2_value) {
        invalid(repass, helperMsg);
        return false;
    } else {
        valid(repass);
        return true;
    }
}

function checkMatchEmail(helperMsg) {
    elem_value = $('#email').val();
    elem2_value = $('#re-email').val();
    if (elem_value != elem2_value) {
        invalid('re-email', helperMsg);
        return false;
    } else {
        valid('re-email');
        return true;
    }
}

function valid(element) {
    $("#" + element).removeClass("redborder");
    $("#" + element).parent().find('.label_error').prev().remove();
    $("#" + element).parent().find('.label_error').remove();
    $("#" + element).parent().find('.label_success').prev().remove();
    $("#" + element).parent().find('.label_success').remove();
}

function invalid(element, helperMsg) {
    $("#" + element).parent().find('.label_error').prev().remove();
    $("#" + element).parent().find('.label_error').remove();
    $("#" + element).parent().find('.label_success').prev().remove();
    $("#" + element).parent().find('.label_success').remove();
    $('<br/><div class=\'label_error\'>' + helperMsg + '</div>').insertAfter($('#' + element).parent().children(':last'));
    $("#" + element).addClass("redborder");
    $("#" + element).focus();
}

function checkAll(n, fldName, c) {
    if (!fldName) {
        fldName = 'cb';
    }
    var f = document.fontForm;
    var n2 = 0;
    for (i = 0; i < n; i++) {
        cb = eval('f.' + fldName + '' + i);
        if (cb) {
            cb.checked = c;
            n2++;
        }
    }
    if (c) {
        document.fontForm.boxchecked.value = n2;
    } else {
        document.fontForm.boxchecked.value = 0;
    }
}

function isChecked(isitchecked) {
    if (isitchecked == true) {
        document.fontForm.boxchecked.value++;
    } else {
        document.fontForm.boxchecked.value--;
    }
}

function checkSubmit(msg) {
    if (document.fontForm.boxchecked.value == 0) {
        alert(msg);
        return false;
    } else {
        return true;
    }
}

function submitform(pressbutton) {
    if (pressbutton) {
        document.fontForm.task.value = pressbutton;
    }
    if (typeof document.fontForm.onsubmit == "function") {
        document.fontForm.onsubmit();
    }
    document.fontForm.submit();
}

function submitform(pressbutton, msg) {
    if (msg) {
        if (confirm(msg)) {
            if (pressbutton) {
                document.fontForm.task.value = pressbutton;
            }
            if (typeof document.fontForm.onsubmit == "function") {
                document.fontForm.onsubmit();
            }
            document.fontForm.submit();
        }
    }
}