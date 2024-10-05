@component('mail::message')
<strong>SMART CAR PARK</strong><br>
<h1>Hello, {{ $data['name'] }}</h1>
    

<p>Reminders Mr/Mrs. {{ $data['lname'] }}. Your  {{ $data['hour'] }} hr(s) Park Reservation at {{ $data['park_name'] }}  will start {{ $data['no_mins'] }} minute(s) from now. Thank You!</p>


@endcomponent
