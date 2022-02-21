@extends('layouts.auth')
@section('css')
@livewireStyles
@endsection

@section('content')
    <livewire:account-preview :accounts="$accounts" />
    
@endsection

@section('js')
@livewireScripts
@stack('scripts')
<script>
// var pusher = new Pusher('89723c45f605cf554606',
// {
//     encrypted: true,
//     cluster: 'us2'
// });

// let user_id = document.querySelector("meta[name='user-id']").getAttribute('content');

// // Subscribe to the channel we specified in our Laravel Event
// var channel = pusher.subscribe('notification.broadcast.' + user_id);

// // Bind a function to a Event (the full Laravel class)
// channel.bind('notification', function(data)
// {
//     // this is called when the event notification is received...
//     console.log(data);
// });
</script>
@endsection