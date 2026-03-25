var idList, hasListColor, hasListImage;

function addListValue(){
    let value = prompt('Введите новое значение', '???');

    if(!value || value.trim() == '' || value.trim() == '???')
        return;

    $.post('/admin/products/types/' + idList + '/add', {value}, function(req){

        if(addError(req.error)) return;

        // {ok:true, item:{id:##, value:"..."}}
        let li = `
            <li id="value${req.item.id}">#${req.item.id} <span>${req.item.value}</span>
            <a class="link-primary" onclick="editListValue(${req.item.id})"><i class="fa fa-pencil"></i></a>
            <a class="link-danger" onclick="deleteList(${req.item.id})"><i class="fa fa-trash-o"></i></a>
        `;

        if(hasListColor)
            li += '<div class="color-box" style="background-color: ' + req.item.value + '"></div>';

        if(hasListImage)
            li += '<img class="color-box" src="' + req.item.value + '">';

        $('#listUL').append(li + '</li>');
    }, 'json');
}

function editListValue(id){
    let value = prompt('Введите новое значение', $('#value'+id+' > span').text());

    if(!value || value.trim() == '' || value.trim() == '???')
        return;

    $.post('/admin/products/types/' + idList + '/update', {id, value}, function(req){

        if(addError(req.error)) return;

        // {ok:true, item:{id:##, value:"..."}}
        $('#value'+id+' > span').text(req.item.value)
        if(hasListColor)
            $('#value'+id+' > div').css('background-color',req.item.value);
    }, 'json');
}

function deleteListValue(id){
    let value = $('#value'+id+' > span').text();
    if(confirm('Вы действительно хотите удалить элемент "'+ value +'"?'))
        $.post('/admin/products/types/' + idList + '/delete', {id, value}, function(req){

        if(addError(req.error)) return;

        // {ok:true, item:{id:##, value:"..."}}
        $('#value'+id).remove();
    }, 'json');
}
