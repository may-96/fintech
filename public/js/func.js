//Transaction js functions
//function to hide and make visible note or add note section
function makevisible()
{
    var x = document.getElementById("icon");
    var y = document.getElementById("save");
    var note  = document.getElementById("note");
    var savdnote = document.getElementById("noteapp")
    if (x.style.display === "block") {
        note.style.display="block";
        x.style.display="none";
        y.style.display="block";
        savdnote.style.display="none";

    } else if(y.style.display==="block"){
        savenote();
        note.style.display="none";
        x.style.display="block";
        y.style.display="none";
        savdnote.style.display="block";

    }
}
//function to save and retreive note written in textarea
function savenote(){
    var value=document.getElementById("note").value;
    document.getElementById("noteapp").innerText=value;
}

function next(){

    var step1=document.getElementsByClassName("sone");
    var step2=document.getElementsByClassName("stwo");
    var step3=document.getElementsByClassName("sthree");
    var step4=document.getElementsByClassName("sfour");
    var country;
    var bank;
    var accessdays;
    var scope;
    var max_data_days;


    if(step1[0].style.display === "block")
    {
        country = document.getElementById("country").value;
        bank = document.getElementById("bank").value;
        for (var i=0; i<step1.length; i++)
        {
            step1[i].style.display="none";
        }
        for (var i=0; i<step1.length; i++)
        {
            step2[i].style.display="block";
        }



    } else if(step2[0].style.display === "block")
    {
        accessdays=document.getElementById("accessdays").value;
        scope=document.getElementById("scope").value;
        max_data_days =document.getElementById("mddays").value;
        for (i=0; i<step2.length; i++)
        {
            step2[i].style.display="none";
        }
        for (var i=0; i<step3.length; i++)
        {
            step3[i].style.display="block";
        }
    }else if(step3[0].style.display === "block")
    {
        for (i=0; i<step3.length; i++)
        {
            step3[i].style.display="none";
        }
        for (var i=0; i<step4.length; i++)
        {
            step4[i].style.display="block";
        }
        document.getElementById("n1").value="Done";
    }
}
