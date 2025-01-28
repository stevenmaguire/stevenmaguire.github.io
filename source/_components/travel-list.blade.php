@if(isset($travelLogs))
<div class="travel-summary">
    @foreach($travelLogs as $travelLog)
    <article>
        <h3><a href="{{ $travelLog->getUrl() }}" rel="nofollow">{{ $travelLog->title }}</a></h3>
        <p>
            <small><em>Observed {{ $travelLog->createdAt()->toFormattedDateString() }}</em></small>
            @if($travelLog->tags)
            &bull;
            <small><em>{{ collect($travelLog->tags)->join(' ') }}</em></small>
            @endif
        </p>
    </article>
    @endforeach
</div>
@endif
