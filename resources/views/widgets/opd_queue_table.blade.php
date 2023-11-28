<style>
    .notification-badge {
        animation: blinkAnimation 1s infinite;
        /* Blinking animation */
    }

    @keyframes blinkAnimation {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
</style>

<div class="row m-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Awaiting Patients in Triage</h2>
                <table class="table">
                    <tbody>
                        @foreach ($opdQueueToBe->chunk(4) as $chunk)
                            <tr>
                                @foreach ($chunk as $encounter)
                                    <td>
                                        <h4>Student ID: {{ $encounter->student->id_number ?? '-' }}</h4>
                                        <p class="notification-badge"
                                            style="font-size:20px; color:yellow; font-weight:bold;">
                                            <i class="fa fa-wheelchair"> </i>
                                            @if ($encounter->status === 1)
                                                Waiting
                                            @elseif ($encounter->status === 2)
                                                Called by the Doctor
                                            @elseif ($encounter->status === 3)
                                                Encounter Closed
                                            @else
                                                Waiting
                                            @endif

                                            <span id="timeCounter" class="right badge badge-danger">

                                                {{ $encounter->created_at->diffForHumans() }} 

                                                {{-- @if ($encounter->created_at)
                                                    @php
                                                        $acceptedTime = \Carbon\Carbon::parse($encounter->created_at);
                                                        $diffInMinutes = $acceptedTime->diffInMinutes();
                                                        $diffInHours = $acceptedTime->diffInHours();
                                                        $diffInDays = $acceptedTime->diffInDays();
                                                    @endphp

                                                    @if ($diffInMinutes < 60)
                                                        {{ $diffInMinutes }} minutes ago
                                                    @elseif($diffInHours < 24)
                                                        {{ $diffInHours }} hours ago
                                                    @else
                                                        {{ $diffInDays }} days ago
                                                    @endif
                                                @else
                                                    /
                                                @endif --}}
                                            </span>
                                        </p>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $opdQueueToBe->links() }}
            </div>
        </div>
    </div>
</div>



