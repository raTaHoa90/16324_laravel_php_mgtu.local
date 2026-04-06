function cancel(event){
    event.stopPropagation();
    event.preventDefault();
    return false;
}

function addProduct(idProduct){
    $.post('/add-product', {idProduct},function(req){
        if(req.ok)
            setProduct(req.count);
    }, 'json');
}

function setProduct(count){
    $('#countProduct').text('('+count+')');
}
