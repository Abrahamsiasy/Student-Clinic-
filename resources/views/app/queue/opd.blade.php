@extends('layouts.app_queue')

@section('content')
    <div class="container-fluid" style="height: 100vh;">
        <div class="row" style="height: 63%!important;;" height: 65%!important;>
            <div class="col-7" style="height: 63%;">
                <div class="p-2">
                    {{ Widget::run('opdQueueCard') }}
                </div>
            </div>
            <div class="col-5 mt-3 " style="height: 63%;">
                <!-- Content for the col-3 section -->
                <div id="videoContainer" style="width: 100%; height: 700px; overflow: hidden;">
                    <video id="videoPlayer" width="100%" height="auto" controls autoplay loop muted>
                        <source src="{{ asset('desk_image/videos/1.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
        <div class="col-md-12 bg-info" style="min-height: 35%;">
            <div class="p-2">
                {{-- {{ Widget::run('opdQueueTable') }} --}}
                <!-- resources/views/your-view.blade.php -->

                <div id="opdQueueContainer">
                    {{-- <x-queue.que-to-be-table :opdQueueToBe="$opdQueueToBe" /> --}}
                    <div class="row m-2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Add an ID to the table for easier reference -->
                                    <table id="opdQueueTable" class="table">
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
                                                                    @if ($encounter->created_at)
                                                                        {{ $encounter->created_at?->diffForHumans() }}
                                                                    @endif
                                                                </span>

                                                            </p>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $opdQueueToBe->links() }}
                                    <!-- Add a script section to handle AJAX updates -->
                                    @push('scripts')
                                        <script>
                                            function updateOpdQueueContent() {
                                                $.ajax({
                                                    url: '{{ route('opd-to-be') }}',
                                                    method: 'GET',
                                                    success: function(data) {
                                                        $('#opdQueueTable tbody').html(data.html);
                                                        console.log(data);
                                                    },
                                                    error: function(error) {
                                                        console.error('Error updating OPD queue content:', error);
                                                    }
                                                });
                                            }

                                            // Call the function on document ready or as needed
                                            $(document).ready(function() {
                                                // Update content initially
                                                updateOpdQueueContent();

                                                // Schedule updates at intervals (e.g., every 5 seconds)
                                                setInterval(updateOpdQueueContent, 5000);
                                            });
                                        </script>
                                    @endpush

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{--         
        <script>
            // Unmute the video after 5 seconds
            const videoPlayer = document.getElementById('videoPlayer');


            // videoPlayer.muted = false;

            // const videoPlayer = document.getElementById('videoPlayer');
            const videoSources = [
                '{{ asset('desk_image/videos/1.mp4') }}',
                '{{ asset('desk_image/videos/2.mp4') }}',
                '{{ asset('desk_image/videos/3.mp4') }}'
            ];
            let currentVideoIndex = 0;

            videoPlayer.addEventListener('ended', playNextVideo);

            function playNextVideo() {
                if (currentVideoIndex < videoSources.length - 1) {
                    currentVideoIndex++;
                    videoPlayer.src = videoSources[currentVideoIndex];
                    videoPlayer.load();
                    videoPlayer.play();
                } else {
                    // All videos have played
                    // You can add any further actions here, like looping back to the first video
                }
            }

            // Start playing the first video
            videoPlayer.play();
        </script> --}}

    </div>
@endsection
