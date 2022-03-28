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
    document.getElementById("notification_sound")
        .play();
});

async function updateNotifications(action, id = null)
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
    await $.ajax(
    {
        url: url,
        type: "POST",
        contentType: 'application/json',
        data:
        {},
        success: function(data, textStatus, jqXHR)
        {
            notifications = data.data;
            renderNotifications();
        },
        error: function(jqXHR, textStatus, errorThrown) {},
    });
}

function renderNotifications()
{
    var notification_list = $('#notifications-list');
    notification_list.html('');
    var notification_count = $('#notification_count');
    notification_count.html('');
    var unread_count = 0;

    if (notifications)
    {
        notifications.forEach(element =>
        {
            let icon = 'uil-file-share-alt';
            let icon_color = 'bg-pale-primary';
            let action = "open_share_link";
            if (element.type == 'request_report')
            {
                action = 'open_modal';
                icon_color = 'bg-pale-green';
                icon = 'uil-suitcase'
            }
            if (element.type == 'report_share')
            {
                action = 'open_report_link';
                icon_color = 'bg-pale-orange';
                icon = 'uil-chart'
            }

            if (element.type == 'account_expired')
            {
                action = 'open_my_accounts_page';
                icon_color = 'bg-pale-red';
                icon = 'uil-folder-times'
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
                <li class="notification-item p-2 mb-1 bg-soft-ash border-bottom" >
                    <div class="d-flex lh-1 justify-content-between">
                        <span class="notification-span d-flex pe-1 fs-14" style="white-space: pre-wrap;" onclick="notification_action('` + action + `','` + element.data + `','` + element.id + `')">
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
    }
    if (unread_count != 0)
    {
        notification_count.html(unread_count);
    }
    if (!notifications || notifications.length == 0)
    {
        let elem = `
            <p class="p-2 alert alert-secondary">There is No Notification ...</p>
        `;
        notification_list.html(elem);
    }

}

async function notification_action(action, data, id)
{
    await updateNotifications('read', id);
    if (action == 'open_share_link')
    {
        let new_url = basePath + "/shared/transactions/" + data;
        window.location.href = new_url;
    }
    else if (action == 'open_report_link')
    {
        let new_url = basePath + "/report/" + data;
        window.location.href = new_url;
    }
    else if (action == 'open_my_accounts_page')
    {
        let new_url = basePath + "/my_accounts";
        window.location.href = new_url;
    }
    else
    {
        document.getElementById('user_id_notification')
            .value = data;
        var myModal = new bootstrap.Modal(document.getElementById('report_shareform_notification'),
        {
            keyboard: false,
            backdrop: 'static',
        });
        myModal.show();
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

$('#addUserBtn_notification')
    .on('click', () =>
    {
        let csn = document.querySelector('#credit_score_notification')
            .checked;
        let ion = document.querySelector('#initials_only_notification')
            .checked;
        let aion = document.querySelector('#account_initials_only_notification')
            .checked;
        let cfn = document.querySelector('#cash_flow_notification')
            .checked;
        let en = document.querySelector('#expenses_notification')
            .checked;
        let inn = document.querySelector('#income_notification')
            .checked;
        let ecn = document.querySelector('#email_check_notification')
            .checked;
        let cn = document.querySelector('#contact_notification')
            .checked;
        let uid = document.querySelector('#user_id_notification')
            .value;
        let url = basePath + "/report/grant_access";

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
            data:
            {
                view_credit_score: csn,
                view_initials_only: ion,
                view_account_initials_only: aion,
                view_cash_flow: cfn,
                view_expense: en,
                view_income: inn,
                view_email: ecn,
                view_contact: cn,
                shared_with: uid
            },
            success: function(data, textStatus, jqXHR)
            {
                document.querySelector('#report_notification_share_message')
                    .innerHTML = data;
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                document.querySelector('#report_notification_share_message')
                    .innerHTML = "Error raised while sharing report.";
            },
        });


    });