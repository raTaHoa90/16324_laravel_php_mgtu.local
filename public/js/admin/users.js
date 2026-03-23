function openNewUserDlg(){
    $('#addUserDlg')[0].showModal();
}

function sendNewUser(){
    let formData = new FormData($('#adduser')[0]);

    $.ajax({
        type: 'POST',
        url: '/admin/users/create-user',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: req => {
            console.log(req);
            if(req.error){
                //this.addError(req.error);
                alert(req.error);
                return;
            }
            location.reload();
        }
    });
    $('#addUserDlg')[0].close();
}
