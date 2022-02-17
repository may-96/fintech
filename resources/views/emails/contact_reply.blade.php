@component('mail::message')
# Hi there,

You have received a contact form query. Following are the details:

# Name : {{ $name }}

# Email : {{$email}}

# Subject: {{$subject}}

# Message :

{{$message}}


Have a good day.
@endcomponent
