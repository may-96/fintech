@component('mail::message')
# Hi there,

Hope you are doing well. {{ $user->fname }} {{ $user->lname }} has requested your credit report.

We have sent you a notification on your account. Please login to your account and share the report by opening the notification from the topbar.

@component('mail::button', ['url' => env('APP_URL').'/login'])
Login to Your Account
@endcomponent

If you are not able to access the button then follow this URL [{{ env("APP_URL")."/login" }}]({{ env("APP_URL")."/login" }}). Thanks

Have a good day.
@endcomponent
