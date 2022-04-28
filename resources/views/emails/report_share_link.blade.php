@component('mail::message')
Hi there,

You can share you credit report following these simple steps:

- 1. Login to your account.
- 2. Connect Your Bank Account.
- 3. Share Your Credit Report. 

Please follow the link below or click this button to share your credit report. Thanks

@component('mail::button', ['url' => env('APP_URL') . "/" . $token])
Go To Link
@endcomponent

If you are not able to access the button then follow this URL [{{ env('APP_URL') . "/" . $token }}]({{ env('APP_URL') . "/" . $token }})

Have a good day.
@endcomponent
