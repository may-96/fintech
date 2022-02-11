//Transaction js functions
//function to hide and make visible note or add note section
async function makevisible(id)
{
    let add_note = document.getElementById("add_note_" + id);
    // let save_note = document.getElementById("save_note_" + id);
    let edit_note = document.getElementById("edit_note_" + id);

    let note_textarea = document.getElementById("note_textarea_" + id);
    let note_display = document.getElementById("note_display_" + id);

    if(add_note.classList.contains('d-block') || edit_note.classList.contains('d-block')){
        toggle_class(add_note, 'd-block', 'd-none');
        toggle_class(edit_note, 'd-block', 'd-none');
        toggle_class(note_display, 'd-block','d-none');

        toggle_class(note_textarea, 'd-none', 'd-block');
        // toggle_class(save_note, 'd-none', 'd-block');
    }
    else if(add_note.classList.contains('d-none') || edit_note.classList.contains('d-none')){
        let note_content = saveNote(note_textarea, note_display);
        toggle_class(note_textarea, 'd-block', 'd-none');
        if(note_content == ""){
            toggle_class(edit_note, 'd-block', 'd-none');
            toggle_class(note_display, 'd-block','d-none');
            toggle_class(add_note, 'd-none', 'd-block');
        }
        else{
            toggle_class(add_note, 'd-block', 'd-none');
            toggle_class(edit_note, 'd-none', 'd-block');
            toggle_class(note_display, 'd-none','d-block');
        }
    }


    // else if(save_note.classList.contains('d-block')){
    //     let note_content = saveNote(note_textarea, note_display);
        
    //     toggle_class(note_textarea, 'd-block', 'd-none');
    //     toggle_class(save_note, 'd-block', 'd-none');

    //     if(note_content == ""){
    //         toggle_class(edit_note, 'd-block', 'd-none');
    //         toggle_class(note_display, 'd-block','d-none');
    //         toggle_class(add_note, 'd-none', 'd-block');
    //     }
    //     else{
    //         toggle_class(add_note, 'd-block', 'd-none');
    //         toggle_class(edit_note, 'd-none', 'd-block');
    //         toggle_class(note_display, 'd-none','d-block');
    //     }        
    // }
}

//function to save and retreive note written in textarea
function saveNote(note_textarea, note_display)
{
    var value = note_textarea.value.trim();
    note_display.innerText = value;
    return value;
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