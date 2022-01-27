let emails = [];

function adduser(e)
{
    e.preventDefault();
    var email_textarea = document.getElementById("textarea");
    var value = email_textarea.value.trim();
    if (!value) return;
    if (emails.includes(value)) return;
    emails.push(value);
    renderList();
}


function renderList()
{
    let container = document.querySelector("#listuser");
    let input = document.querySelector("#textarea");
    container.innerHTML = "";
    input.value = "";
    emails.forEach(email => container.innerHTML += `<div class="d-flex justify-content-between rounded bg-soft-ash m-1 p-2"><div class="d-flex"><img class="h-5 me-1 rounded-circle" src='https://ui-avatars.com/api/?name=${email}.jpg'/> <p class="m-0">${email}</p></div> <a href="#" class="float-end text-danger ms-2" onclick="remove('${email}')"><i class="uil uil-minus"></i></a></div>`);
}

function clear()
{
    emails = [];
    renderList();
}

function remove(email)
{
    emails = emails.filter(item => item != email);
    renderList();
}

// document.getElementById("some").addEventListener("click", clear);
document.querySelector("#addUserBtn").addEventListener("click", adduser);