function showhide(id)
{
    console.log("hello");
let edit= document.getElementById("edit-" + id);
let save= document.getElementById("save-" + id);

let field=document.getElementById("field-" + id);
let value=document.getElementById("val-" + id);

    console.log(save);

    if(edit.classList.contains('d-block')){
        console.log("helloe");
        toggle_class(edit, 'd-block', 'd-none');
        toggle_class(value, 'd-block','d-none');
        toggle_class(save, 'd-none', 'd-block');
        toggle_class(field, 'd-none', 'd-block');
    }
    else if(save.classList.contains('d-block')){
        console.log("hellos");
        var val=saveField(field, value);
        toggle_class(field, 'd-block', 'd-none');
        toggle_class(save, 'd-block', 'd-none');
        toggle_class(value, 'd-none','d-block');
        toggle_class(edit, 'd-none', 'd-block');
    }
}


    function saveField(field,value)
    {
        let val = (field.value).trim();
        if(value != "")
        {
            value.textContent = val;
            return val;
        }
        return "";
    }
function toggle_class(elem, class_to_remove, class_to_add)
{
    if (elem.classList.contains(class_to_remove))
    {
        elem.classList.remove(class_to_remove);
    }
    if (!elem.classList.contains(class_to_add))
    {
        elem.classList.add(class_to_add);
    }
}
