async function showhide(id)
{
let edit= document.getElementById("edit-"+id);
let save= document.getElementById("save-"+id);

let field=document.getElementById("field-"+id);
let value=document.getElementById("val-"+id);






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
