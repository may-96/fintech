@component('mail::message')
# Hi there,

Hope you are doing well. {{ $user->fname }} {{ $user->lname }} has requested your credit report.

It seems that you don't have an account on our website. Please create a new account and get your Credit Worthiness Report.

@component('mail::button', ['url' => env('APP_URL').'/register'])
Register an Account
@endcomponent

If you are not able to access the button then follow this URL [{{ env("APP_URL")."/register" }}]({{ env("APP_URL")."/register" }}). Thanks

Have a good day.
@endcomponent
