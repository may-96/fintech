@component('mail::message')
# Hi {{$shared_user->fname}},

Hope you are doing well. {{ $user->fname }} {{ $user->lname }} has shared his/her credit report with you.

Please login to your account to view the credit report. Use the link below to access the report.

@component('mail::button', ['url' => env('APP_URL').'/report/'.$token])
View Report
@endcomponent

If you are not able to access the button then follow this URL [{{ env("APP_URL").'/report/'.$token }}]({{ env("APP_URL").'/report/'.$token }}). Thanks

Have a good day.
@endcomponent
