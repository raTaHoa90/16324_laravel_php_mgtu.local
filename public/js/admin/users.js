function openNewUserDlg(){
    $('#addUserDlg')[0].showModal();
}

function sendNewUser(){
    let formData = new FormData($('#adduser')[0]);

    ajaxPostForm('/admin/users/create-user', formData, '#addUserDlg');
}
