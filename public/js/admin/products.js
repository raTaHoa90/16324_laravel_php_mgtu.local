var paramTypesList = [],
    lists = {},
    generateID = GenerateID(),
    TYPE_LIST_VALUES_USER_SELECT,
    params = {};

function* GenerateID(){
    let lastID = 0;
    while(true)
        yield --lastID;
}

function paramTypeChange(select){
    if(paramTypesList.includes(+select.value)){
        $('#typeText')[0].classList.add('hide');
        $('#typeList')[0].classList.remove('hide');

        $('#listValues')[0].multiple = select.value == TYPE_LIST_VALUES_USER_SELECT;

    } else {
        $('#typeText')[0].classList.remove('hide');
        $('#typeList')[0].classList.add('hide');
    }
}

function listChange(select){
    // <option value="{{$list->id}}">{{$list->caption}}</option>
    let listValues = $('#listValues')[0];
    listValues.innerHTML = '<option value=0>- не выбрано -</option>';
    if(!select.value)
        return;

    let list = lists[select.value];
    if(!list){
        addError("Нет такого листа");
        $('#paramDlg')[0].close();
        return;
    }

    for(let value of list)
        listValues.options.add(new Option(value.caption, value.id))

}

function addParamDlg(){
    $('#idParam').val(generateID.next().value);
    $('#caption').val('');
    $('#paramType').val(0);
    $('#list').val(0);
    $('#listValues').val(0);
    $('#textValue').val('');
    $('#typeText')[0].classList.remove('hide');
    $('#typeList')[0].classList.add('hide');

    $('#paramDlg')[0].showModal();
}


function paramSet(){
    let param = {
        id: +$('#idParam').val(),
        caption: $('#caption').val(),
        type: +$('#paramType').val(),
    };

    if(paramTypesList.includes(param.type)){
        param.listid = +$('#list').val();

        if(param.type == TYPE_LIST_VALUES_USER_SELECT){
            let res = [];
            $('#listValues :selected').each((i, item) => {
                res.push(item.value);
            });
            param.value = res.join(',');
        } else
            param.value = $('#listValues').val();
    } else
        param.value = $('#textValue').val();

    params[param.caption] = param;
    $('#paramDlg')[0].close();

    drawParams();
}

function drawParams(){
    let res = [];

    for(let pName in params){
        let param = params[pName],
            type = $('#paramType [value=' + param.type + ']').text(),
            value = param.value,
            list = '';

        if(paramTypesList.includes(param.type)){
            list = $('#list [value=' + param.listid + ']').text();
            if(param.type == TYPE_LIST_VALUES_USER_SELECT) {
                let ids = param.value.split(',');
                value = '';
                for(let v of lists[param.listid])
                    if(ids.includes(v.id))
                        value += v.caption + '<br>';
            } else {
                let v = lists[param.listid].find(value => value.id == param.value);
                value = v ? v.caption : '';
            }
        }

        res.push(`<tr id=param_${param.id}>
            <td>${pName}</td>
            <td>${type}</td>
            <td>${value}</td>
            <td>${list}</td>
            <td></td>
        </tr>`);
    }

    $('#params').html(res.join(''));
}
