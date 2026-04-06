function openNewUserDlg(){
    $('#addUserDlg')[0].showModal();
}

function sendNewUser(){
    let formData = new FormData($('#adduser')[0]);

    ajaxPostForm('/admin/users/create-user', formData, '#addUserDlg');
}

function setRoleUser( userID, roleID){
    $.post('/admin/users/set-role', {uid:userID, rid: roleID}, function(req){
        if(addError(req.error)) return;
    });
}
