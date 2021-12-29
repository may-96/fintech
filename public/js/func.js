//Transaction js functions
//function to hide and make visible note or add note section
function makevisible()
{
    var x = document.getElementById("icon");
    var y = document.getElementById("save");
    var note = document.getElementById("note");
    var savdnote = document.getElementById("noteapp")
    if (x.style.display === "block")
    {
        note.style.display = "block";
        x.style.display = "none";
        y.style.display = "block";
        savdnote.style.display = "none";

    }
    else if (y.style.display === "block")
    {
        savenote();
        note.style.display = "none";
        x.style.display = "block";
        y.style.display = "none";
        savdnote.style.display = "block";
    }
}

//function to save and retreive note written in textarea
function savenote()
{
    var value = document.getElementById("note")
        .value;
    document.getElementById("noteapp")
        .innerText = value;
}