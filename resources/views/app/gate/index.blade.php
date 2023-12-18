@extends('layouts.app')

@section('content')
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        Gate Control System
                    </h4>
                </div>


                <h2 class="text-center mb-4">Gate Control System</h2>

                <!-- Input Form for Student ID -->
                <form>
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Enter Student ID:</label>
                        <input type="text" class="form-control" id="studentId" placeholder="Student ID">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="fetchStudentInfo()">Get Student
                        Info</button>
                </form>

                <form id="checkInForm" action="{{ route('gate.index') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="search" autocomplete="off" id="manualInput" name="student_id"
                            class="form-control form-control-lg" placeholder="Enter Student ID here">

                        <input type="text" id="barcodeInput" class="form-control form-control-lg" style="display: none;"
                            placeholder="Scan Barcode">
                        <div class="input-group-append">

                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-search"></i><b> Check in </b>
                            </button>
                        </div>
                    </div>

                </form>

                <!-- Display Area for Student Information -->
                <div id="studentInfo" class="mt-4" style="display: none;">
                    {{-- @if (isset($student)) --}}
                    <!-- JavaScript to Fetch and Display Student Information -->
                    <script>
                        function fetchStudentInfo() {
                            // Dummy data for demonstration
                            const studentData = {
                                name: "John Doe",
                                rollNumber: "ABC123",
                                department: "Computer Science",
                                // Add more fields as needed
                            };

                            // Display student information
                            document.getElementById("studentInfo").style.display = "block";
                            document.getElementById("studentInfo").innerHTML = `
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="https://th.bing.com/th/id/OIP.7G_WlWFRa7uxMxCZZ0qQngHaE7?rs=1&pid=ImgDetMain" alt="Student Photo" class="img-fluid rounded-circle">
                </div>
                <div class="col-md-5">
                    <h3>Student Information</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> ${studentData.name}</li>
                        <li class="list-group-item"><strong>Roll Number:</strong> ${studentData.rollNumber}</li>
                        <li class="list-group-item"><strong>Department:</strong> ${studentData.department}</li>
                        <!-- Add more personal information fields as needed -->
                    </ul>
                </div>
            </div>
        `;
                        }
                    </script>
                    {{-- @endif --}}
                </div>

                <script>
                    $(function() {
                        var audioContext = new(window.AudioContext || window.webkitAudioContext)();
                        var manualInput = document.getElementById("manualInput");
                        var recordFoundAudio = new Audio('assets/checked-in.mp3');
                        // event.preventDefault();
                        manualInput.addEventListener('input', function() {
                            var manualInput = document.getElementById("manualInput");
                            var currentSearchValue = manualInput.value.replace(/\s/g, '');
                            localStorage.setItem('lastSearchValue', currentSearchValue);
                            manualInput.value = currentSearchValue;

                            event.preventDefault();
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('checkin') }}',
                                data: $('#checkInForm').serialize(),
                                dataType: 'json',
                                success: function(response) {
                                    console.log('Record exists:', response.success);

                                    if (response.success) {
                                        // Play the record found audio
                                        playRecordFoundSound();
                                        // Set a timeout to delay the redirect until after the sound playback
                                        setTimeout(function() {
                                                window.location.href = '{{ route('home') }}';
                                            }, recordFoundAudio.duration *
                                            1000); // Convert duration to milliseconds
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                }
                            });
                        });

                        function playRecordFoundSound() {
                            if (audioContext.state === 'suspended') {
                                audioContext.resume().then(function() {
                                    playAudio(recordFoundAudio);
                                });
                            } else {
                                playAudio(recordFoundAudio);
                            }
                        }

                        function playAudio(audio) {
                            // Play the audio directly
                            audio.play();
                        }

                        manualInput.focus();
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
