Pusher.logToConsole = true;

var basePath = window.location.origin;
var notifications = [];

var pusher = new Pusher('89723c45f605cf554606',
{
    encrypted: true,
    cluster: 'us2'
});

let user_id = document.querySelector("meta[name='user-id']")
    .getAttribute('content');

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('notification.broadcast.' + user_id);

// Bind a function to a Event (the full Laravel class)
channel.bind('notification', function(data)
{
    // this is called when the event notification is received...
    console.log(data);
    notifications.unshift(data.notification);
    
    renderNotifications();
    document.getElementById("notification_sound").play();
});

function updateNotifications(action, id = null)
{

    let url = basePath + "/notification/" + action;
    if (id !== null)
    {
        url = url + "/" + id;
    }

    $.ajaxSetup(
    {
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                .attr('content')
        }
    });
    $.ajax(
    {
        url: url,
        type: "POST",
        contentType: 'application/json',
        data:
        {},
        success: function(data, textStatus, jqXHR)
        {
            console.log(data);
            notifications = data.data;
            renderNotifications();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            console.log(jqXHR);
        },
    });
}

function renderNotifications()
{
    var notification_list = $('#notifications-list');
    notification_list.html('');
    var notification_count = $('#notification_count');
    notification_count.html('');
    var unread_count = 0;

    notifications.forEach(element =>
    {
        let icon = 'uil-file-share-alt';
        let icon_color = 'bg-pale-primary';
        let action = "open_link";
        if (element.type == 'request_report')
        {
            action = 'open_modal';
            icon_color = 'bg-pale-green';
            icon = 'uil-suitcase'
        }
        let read_unread = "";
        if (element.read == 1)
        {
            read_unread += `<a href="#" title="Mark Unread" onclick="updateNotifications('unread',` + element.id + `)" data-id="` + element.id + `"><i class="uil uil-envelope-open"></i></a>`;
        }
        else
        {
            unread_count += 1;
            read_unread += `<a href="#" title="Mark Read" onclick="updateNotifications('read',` + element.id + `)" data-id="` + element.id + `"><i class="uil uil-envelope"></i></a>`;
        }
        var newNotificationHtml = `
            <li class="notification-item p-2 mb-1 bg-soft-ash border-bottom" onclick="notification_action('`+action+`','`+element.data+`')">
                <div class="d-flex lh-1 justify-content-between">
                    <span class="d-flex pe-1 fs-14" style="white-space: pre-wrap;">
                        <span class="fs-30 avatar ` + icon_color + ` me-2" style="min-width: 45px;height: 45px;">
                            <i class="uil ` + icon + `"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <p class="mb-0 text-dark fw-bold fs-13 mt-1 mb-1">` + element.message + `</p>
                            <small class="text-muted fs-11">` + timeSince(new Date(element.created_at)) + `</small>
                        </div>
                    </span>
                    <span style="width: 1.5em;" class="d-flex flex-column align-items-center justify-content-between">
                        ` + read_unread + `
                        <a href="#" title="Delete" onclick="updateNotifications('destroy',` + element.id + `)" data-id="` + element.id + `" class="text-danger"><i class="uil uil-trash-alt"></i></a>
                    </span>
                </div>
            </li>
        `;
        var existingNotifications = notification_list.html();
        notification_list.html(existingNotifications + newNotificationHtml);

    });
    if(unread_count != 0){
        notification_count.html(unread_count);
    }
    
}

function notification_action(action, data){
    if(action == 'open_link'){
        let new_url = basePath + "/shared/transactions/"+data;
        window.location.href = new_url;
    }
    else{

    }
}

function timeSince(date)
{

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = seconds / 31536000;

    if (interval > 1)
    {
        return Math.floor(interval) + " years";
    }
    interval = seconds / 2592000;
    if (interval > 1)
    {
        return Math.floor(interval) + " months";
    }
    interval = seconds / 86400;
    if (interval > 1)
    {
        return Math.floor(interval) + " days";
    }
    interval = seconds / 3600;
    if (interval > 1)
    {
        return Math.floor(interval) + " hours";
    }
    interval = seconds / 60;
    if (interval > 1)
    {
        return Math.floor(interval) + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}

updateNotifications('fetch');