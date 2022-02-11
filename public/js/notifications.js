Pusher.logToConsole = true;

var pusher = new Pusher('89723c45f605cf554606', {
    encrypted: false,
    cluster: 'us2'
});

let user_id = document.querySelector("meta[name='user-id']").getAttribute('content');

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('notification.broadcast.'+user_id);

// Bind a function to a Event (the full Laravel class)
channel.bind('notification', function(data) {
    // this is called when the event notification is received...
    console.log(data);
});

var basePath = window.location.origin;
var notifications = [];

function fetchNotifications(action, id=null){
    
    let url = basePath + "/notification/" + action;
    if(id !== null){
        url = url + "/" + id;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        type: "POST",
        contentType: 'application/json',
        data: {},
        success: function (data, textStatus, jqXHR) {
            console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        },
    });
}

function renderNotifications(){

}

fetchNotifications('fetch');