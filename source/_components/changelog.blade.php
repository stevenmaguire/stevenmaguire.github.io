<h2>Changelog</h2>

<ul>
    @foreach($changelog as $event)
    <li>{{ Carbon\Carbon::parse($event->date)->format('Y-m-d') }} - {{ $event->message }}</li>
    @endforeach
</ul>
