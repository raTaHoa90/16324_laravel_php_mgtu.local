var categories = {};

function openAddCategory(){
    $('#idCategory').val('');
    $('#caption').val('');
    $('#parent_id').val(0);
    $('#desc').val('');

    $('#categoryDlg')[0].showModal();
}

function openCategoryEditDlg(idCat){
    let cat = categories[idCat];
    if(!cat) return;

    $('#idCategory').val(idCat);

    $('#caption').val(cat.caption);
    $('#parent_id').val(cat.parent_id);
    $('#desc').val(cat.desc);

    $('#categoryDlg')[0].showModal();
}

function sendCategory(){
    let formData = new FormData($('#formType')[0]),
        url,
        idCat = $('#idCategory').val();

    if(!$('#caption').val().trim())
        return;

    if(idCat == '' ){
        url = '/admin/products/categories/create';
    } else {
        let cat = categories[idCat];
        if(!cat) return;

        url = '/admin/products/categories/update';
        if( $('#parent_id').val() == cat.parent_id &&
            $('#caption').val() == cat.caption &&
            $('#desc').val() == cat.desc
        ) {
            $('#categoryDlg')[0].close();
            return;
        }
    }

    ajaxPostForm(url, formData, '#categoryDlg');
}

function deleteCategory(idCat){
    if(!categories[idCat])
        return;

    $.post('/admin/products/categories/delete', {idCategory:idCat},function(req){
        if(addError(req.error)) return;

        location.reload();
    });
}
