$(function() {



    // var originalSerializeArray = $.fn.serializeArray;
    // $.fn.extend({
    //     serializeArray: function () {
    //         var brokenSerialization = originalSerializeArray.apply(this);
    //         var checkboxValues = $(this).find('input[type=checkbox]').map(function () {
    //             return { 'name': this.name, 'value': this.checked };
    //         }).get();
    //         var checkboxKeys = $.map(checkboxValues, function (element) { return element.name; });
    //         var withoutCheckboxes = $.grep(brokenSerialization, function (element) {
    //             return $.inArray(element.name, checkboxKeys) == -1;
    //         });
    //         console.log(withoutCheckboxes);
    //         console.log(checkboxValues);
    //         return $.merge(withoutCheckboxes, checkboxValues);
    //     }
    // });

    /* Quck Modal Hide */
    $('#quickModal').on('hidden.bs.modal', function () {
        $('#quick-form').each(function(){
            this.reset();
        });
        $('#quick-form input, #quick-form select').each(function() {
            if($(this).parent().parent().hasClass('has-error')) {
                $(this).parent().parent().removeClass('has-error');
            }
        });
        $('.err-display').html('');
        $('.err-display').hide();
    });



});


function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function validateForm(formname) {
    if(!$('#'+ formname)[0].checkValidity()) {
        var message = '';
        $("#" +formname+ " input, #" +formname+ " select").each(function() {
          if($(this).prop('required')) {
            if( $(this).attr('type') == 'radio' ) {
                if (!$(this).is(':checked')) {
                    $(this).parent().parent().addClass('has-error');
                    var attr = $(this).attr('placeholder');
                    if (typeof attr !== typeof undefined && attr !== false) {
                        message += "Please " + $(this).attr('placeholder').capitalize() + "<br/>";
                    }
                    else {
                        message += "Please Check Form Required Fields <br/>";
                    }
                }
                else {
                    $(this).parent().parent().removeClass('has-error');
                }
            }
            else {
                if( $(this).val() == '') {
                    $(this).parent().parent().addClass('has-error');
                    var attr = $(this).attr('placeholder');
                    if (typeof attr !== typeof undefined && attr !== false) {
                        message += "Please " + $(this).attr('placeholder').capitalize() + "<br/>";
                    }
                    else {
                        message += "Please Check Form Required Fields <br/>";
                    }
                }
                else {
                  $(this).parent().parent().removeClass('has-error');
                }
            }
          }
        });
        $('.err-display').html(message).show();
        // $('.err-display').html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>' + message);
        return false;
    }
    else {
        $("#" +formname+ " input, #" +formname+ " select").each(function() {
            if($(this).parent().parent().hasClass('has-error')) {
                $(this).parent().parent().removeClass('has-error');
            }
        });
        $('.err-display').html('');
        $('.err-display').hide();

        return true;
    }
}

function emptyForm(formname) {
    $("#" + formname).each(function(){
        this.reset();
    });
    $('.err-display').html('');
    $('.err-display').hide();
}

function getIdfromURL(url) {
    var returl = url.split("/");
    return returl[returl.length-1];
}

function getIdfromid(id) {
    var retid = id.split("-");
    return retid[retid.length-1];
}

function quickAjaxsubmit(url, values, tbl, method) {
    $.ajax({
        type :  method,
        url  :  url,
        data :  values,
        dataType: "json",
        beforeSend: function(xhr){
            console.log(values);
          $('#btn-q-submit').html('Submitting...').attr('disabled','disabled');
        },
        success: function(data){
          //  var result = $.parseJSON(data);
            if(data['status'] == 'success') {
                tbl.ajax.reload( null, false );
                emptyForm('quick-form');
                emptyForm('bonus-form');
                $('#btn-q-submit').removeAttr('disabled').html('<i class="fa fa-save ico-btn"></i> Save');
                $("#quickModal").modal('hide');
                $("#bonusModal").modal('hide');
                $(".success-alert-area").empty().append("<div class='alert alert-success success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+"</div>");
            }
            else {
                $('.err-display').html(data['msg']);
                $('.err-display').show();
                $('#btn-q-submit').removeAttr('disabled').html('<i class="fa fa-save ico-btn"></i> Save');
            }
        },
        error: function(e) {
      console.log(e.responseText);
     }
    });
}


function getEditvalues(url) {
    $.ajax({
        type :  "GET",
        url  :  url,
        //async : false,
        data :  {},
        success: function(data){
            var result = $.parseJSON(data);
            if(result['status'] == 'success') {
                $.each(result, function( index, value ) {
                    if ($("[name='"+index+"']").length) {
                        if($("[name='"+index+"']").is("input")) {
                            if( $("[name='"+index+"']").attr('type') == 'text' || $("[name='"+index+"']").attr('type') == 'hidden' || $("[name='"+index+"']").attr('type') == 'number' || $("[name='"+index+"']").attr('type') == 'color' ) {
                                $("input[name='"+index+"']").val(value);
                            }
                            else if ($("[name='"+index+"']").attr('type') == 'radio') {
                              $("input[name='"+index+"'][value=" + value + "]").prop('checked', true);
                            }
                        }
                        // else if ( $("[name='"+index+"']").attr('type') == 'hidden' ) {
                        //     $("input[name='"+index+"']").val(value);
                        // }
                        else if ($("[name='"+index+"']").is("textarea")) {
                            $("textarea[name='"+index+"']").val(value);
                        }
                        else if ($("[name='"+index+"']").is("select")) {
                            $("select[name='"+index+"']").val(value);
                        }
                    }
                });
            }
            else {
               alert(result['msg']);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR!!!");
            alert(errorThrown);
        }
    });
}

function deleteAjax(url, tbl) {
    $.ajax({
        type :  "DELETE",
        url  :  url,
        data :  {},
        success: function(data){
            //var result = $.parseJSON(data);
            if(data['status'] == 'success') {
                $(".success-alert-area").empty().append("<div class='alert alert-success success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+"</div>");
                //tbl.api().ajax.reload();
                // tbl.fnStandingRedraw();
                tbl.ajax.reload( null, false );
            }
            else {
                if( "msg" in data ) {
                    alert(data['msg']);
                }
                else {
                    alert('Something Wrong');
                }
            }
        },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("ERROR!!!");
          alert(errorThrown);
      }
    });
}

function getAjax(url, tbl) {
    $.ajax({
        type :  "GET",
        url  :  url,
        data :  {},
        success: function(data){
            //var result = $.parseJSON(data);
            if(data['status'] == 'success') {
                $(".success-alert-area").empty().append("<div class='alert alert-success success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+"</div>");
                //tbl.api().ajax.reload();
                // tbl.fnStandingRedraw();
                tbl.ajax.reload( null, false );
            }
            else {
                if( "msg" in data ) {
                    alert(data['msg']);
                }
                else {
                    alert('Something Wrong');
                }
            }
        },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("ERROR!!!");
          alert(errorThrown);
      }
    });
}


function myFixed(value, places) {
    //Check Numeric or Not
    if( $.isNumeric( value ) ) {
        //Check full number or Decimal number
        if(value % 1 != 0 || value.toString().indexOf('.') != -1) {
            var valSplit = value.toString().split(".");
            var decVal = valSplit[1];
            var decLen = decVal.toString().length;
            if(places > decLen) {
                var result = value;
                for (i = 0; i < places - decLen; i++) {
                    result +='0';
                }
            }
            else if(places < decLen){
                var result = valSplit[0] + '.' + decVal.toString().slice(0, places);
            }
            else {
                var result = value;
            }
        }
        else {
            var result = value + '.';
            for (i = 0; i < places; i++) {
                result +='0';
            }
        }
        return result;
    }
    else {
        return value;
    }
}

function htmlspecialchars_decode(text)
{
   var replacements = Array("&", "<", ">", '"', "'");
   var chars = Array("&amp;", "&lt;", "&gt;", "&quot;", "'");
   for (var i=0; i<chars.length; i++)
   {
       var re = new RegExp(chars[i], "gi");
       if(re.test(text))
       {
           text = text.replace(re, replacements[i]);
       }
   }
   return text;
}

/* For Ajax Form Submit */
function getForminfo(form_name, extra_fields) {
    var form_data = new FormData();
    $('#' + form_name + ' *').filter(':input').each(function(i, element){
        var name = $(this).attr('name');
        if($(this).attr('type') == 'file') {
            if($(this).val() != '') {
                form_data.append($(this).attr('name'), $(this).prop('files')[0]);
            }
            else {
                form_data.append($(this).attr('name'), '');
            }
        }
        else if( $(this).attr('type') == 'text' || $(this).is("select")  ||  $(this).is("textarea") || $(this).attr('type') == 'hidden' || $(this).attr('type') == 'number' || $(this).attr('type') == 'color' || $(this).attr('type') == 'password') {
            form_data.append($(this).attr('name'), $(this).val());
        }
        else if(  $(this).attr('type') == 'radio' ) {
            var rdoname = $(this).attr('name');
            form_data.append($(this).attr('name'), $("input:radio[name="+rdoname+"]:checked").val());
        }
        else if(  $(this).attr('type') == 'checkbox' ) {
            var chkname = $(this).attr('name');
            var chkarr = []; var i = 0;
            $("input[name="+chkname+"]:checked").each(function() {
                chkarr[i++] = this.value;
            });
            chkarr = (chkarr.length) ? chkarr.join(',') : '';
            form_data.append($(this).attr('name'), chkarr);
        }

    });

    if( typeof extra_fields !== 'undefined' && extra_fields.length > 0) {
        $.each(extra_fields, function( index, value ) {
            form_data.append(value,$("[name='"+value+"']").val());
        });
    }
    return form_data;
}
