function openTypeEditDlg(idList){
    if(idList){
        $('#formType [name=idList]').val(idList);

        $('#caption').val($('#list'+idList+' td:nth-child(2)').text());

        let typeList = $('#list'+idList+' td:nth-child(3)').text();
        $('#type_list option').each((i, item)=>{
            if($(item).text() == typeList)
                item.selected = true;
        });

    } else {
        $('#formType [name=idList]').val('');
        $('#caption').val('');
        $('#type_list').val(0);
    }
    $('#typeEditDlg')[0].showModal();
}

function sendType(){
    let formData = new FormData($('#formType')[0]),
        url,
        idList = $('#formType [name=idList]').val();

    if(!$('#caption').val().trim())
        return;

    if(idList == '' ){
        url = '/admin/products/types/create';
    } else {
        url = '/admin/products/types/rename';
        if( $('#type_list option:checked').text() == $('#list'+idList+' td:nth-child(3)').text() &&
            $('#caption').val() == $('#list'+idList+' td:nth-child(2)').text()
        ) {
            $('#typeEditDlg')[0].close();
            return;
        }
    }
    ajaxPostForm(url, formData, '#typeEditDlg');
}


function deleteList(idList){
    $.post('/admin/products/types/delete', {idList} , function(req){
        if(addError(req.error)) return;

        if(req.ok)
            $('#list'+idList).remove();

    }, 'json');
}
