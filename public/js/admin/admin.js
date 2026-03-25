function cancel(event){
    event.stopPropagation();
    event.preventDefault();
    return false;
}

function ajaxPostForm(url, formData, dlgID){
    $.ajax({
        type: 'POST',
        url: url ,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: req => {
            console.log(req);
            if(addError(req.error)) return;
            location.reload();
        }
    });
    $(dlgID)[0].close();
}

function addError(error){
    if(error){
        alert(error);
        return true;
    }
    return false;
}
