@extends('layouts.app')

@section('content')

     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center display-4"> Search</h2>


                </div>

                <div class="card-body">

                  
                        <section class="content">
                <div class="container-fluid">
              
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                        



                      <form id="checkInForm" action="{{ route('checkin') }}" method="post">
                        @csrf
                      <div class="input-group">
                        <input type="search" autocomplete="off" id="manualInput" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID here">

                        <input type="text" id="barcodeInput" class="form-control form-control-lg" style="display: none;" placeholder="Scan Barcode">
                        <div class="input-group-append">
                            
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-search"></i><b> Check in </b>
                            </button>
                          </div>
                            </div>
                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </section>
                   
<br><br>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm table-condensed">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                     
                                        <th class="text-left">Student ID </th>
                                        <th class="text-left">Patient Name</th>
                                        <th class="text-left">Age </th>
                                        <th class="text-left">Gender</th>
                                        <th class="text-left"> Date of visit </th>
                                        <th class="text-left">Status  </th>
                                        <th class="text-left"> Mapped RFID</th>
                                        <th class="text-center">
                                            @lang('crud.common.actions')
                                        </th>
                                    </tr>
                                </thead>
        
        
                                <tbody>
                                    @foreach ($encounters as $key => $encounter)
                                        <tr>
        
                                            <td> {{ $key + 1 }}
                                             
                                            <td>{{ $encounter->student->id_number ?? '-' }}</td>
                                            <td>{{ $encounter->student?->fullName ?? '-' }}</td>
                                            <td>
                                                @php
                                                    try {
                                                        $age = \Carbon\Carbon::parse($encounter->student->date_of_birth)
                                                            ->diff(\Carbon\Carbon::now())
                                                            ->format('%y years old');
                                                    } catch (\Exception $e) {
                                                        $age = '<span style="color: red;">Error</span>';
                                                    }
                                                    echo $age;
                                                @endphp
                                            </td>
                                            <td>{{ optional($encounter->student)->sex ?? '-' }}</td>
        
                                            <td>{{ $encounter->created_at->diffForHumans() }} </td>
                                            <td>
                                               
        
                                          
                                                 
                                                    @if($encounter->status ==1 )
                                                      <span class="badge badge-info"> Checked-in</span>
                                                   @elseif($encounter->status ==2 )
                                                   <span class="badge badge-primary"> In-progress</span>
                                                

                                                   @elseif($encounter->status ==3 )
                                                   <span class="badge badge-info"> Case closed</span>
                                                   @else

                                        
                                                <form method="post" action="{{ route('rechecin') }}">
                                                @csrf
                                                <input type="hidden" name="encounter_id" value="{{ $encounter->id }}">
                                                <button type="submit" class="badge badge-danger" >
                                                Missing call
                                                </button>
                                                </form>


                                        
                                                   @endif
                                                   
                                                   
                                               
                                                     
                                             
                                            </td>
                                        <td>{{ $encounter->student->rfid ?? '-' }} </td>
        
                                            <td class="text-right">
                                                <div role="group" aria-label="Row Actions" class="btn-group">
        
        

                                                 
                                                        @can('map-rfid')
                                                        @if($encounter->student->rfid === null )
                                            

                                                            <form method="post" action="{{ route('map-rfid') }}">
                                                                @csrf
                                                                <input type="hidden" name="student_id" value="{{ $encounter->student->id }}">
                                                                <input type="text"   required class="form-control-sm" autocomplete="off"  name="rfid" placeholder="Enter RFID">
                                                                <button type="submit" class="btn btn-sm btn-outline-primary mr-1" > <i class="icon fa fa-plus"></i> Map RFID</button>
                                                            </form>

                                                            @else
                                            
                                                        

                                                                        <form method="post" action="{{ route('unmap-rfid') }}" onsubmit="return confirm('Are you sure to unmap this RFID from the student?');">
                                                                            @csrf

                                                                        <input hidden name="remove_mapping" value="true">
                                                                        <input hidden name="rfid" value="{{ $encounter->student->rfid }}">
                                                                        <button class="btn btn-sm btn-outline-primary mx-1" type="submit">  <i class="icon fa fa-book"></i>  UnMap Rfid</button>
                                                                    </form>
                                                             

                                                            @endif
                                                 
                                                         @endcan
        

                                                        @can('delete', $encounter)
                                                        @if($encounter->status ==1 )
                                                            <form data-route="{{ route('encounters.destroy', $encounter) }}"
                                                                method="POST" id="deletebtnid">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="fa fa-user-minus"></i> Uncheck
                                                                </button>
                                                            </form>
                                                            @elseif($encounter->status ==2)
                                                            <button type="submit" class="btn btn-sm btn-outline-info">
                                                                <i class="fa fa-user"></i> In-Process
                                                            </button>


                                                            @elseif($encounter->status ==3)
                                                            <button type="submit" class="btn btn-sm btn-outline-info">
                                                                <i class="fa fa-user"></i> Case Closed
                                                            </button>

                                                            @else
                                                            <button type="submit" class="btn btn-sm btn-outline-info">
                                                                <i class="fa fa-user"></i> Missing
                                                            </button>
                                                            @endif


                                                        @endcan

                                                  
                                            </td>
                                        </tr>
                                    @endforeach
                        </div>
        
                        @if ($encounters->isEmpty())
                            <tr>
                                <td colspan="6">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                        @endif
        
                        </tbody>
                   
                        </table>
                    
                   
                        <div  class="float-right" style="text-align: right;">
                            {{ $encounters->links() }}
                        </div>
               

                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    $(document).ready(function() {
        var typingTimer; // Timer identifier
        var doneTypingInterval = 2000; // Time in milliseconds (0.5 seconds)

        // Handle keyup event on the manual input field
        $('#manualInput').keyup(function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        // Handle input event on the manual input field (for non-keyboard input)
        $('#manualInput').on('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        // Function to execute when typing is done
        function doneTyping() {
            // Trigger the form submission
            $('#checkInForm').submit();
        }
    });
</script> --}}
{{-- 
<script>
    $(document).ready(function() {
        // Handle keyup event on the manual input field for auto-submit
        $('#manualInput').keyup(function(event) {
            if (event.keyCode === 13) {  // Check if the Enter key is pressed
                // Trigger the form submission
                $('#checkInForm').submit();
            }
        });
    });
</script> --}}

<!-- Include jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    

    $(function() {
    var audioContext = new (window.AudioContext || window.webkitAudioContext)();
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
            url: '{{ route("checkin") }}',
            data: $('#checkInForm').serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Record exists:', response.success);

                if (response.success) {
                    // Play the record found audio
                    playRecordFoundSound();
                   // Set a timeout to delay the redirect until after the sound playback
                   setTimeout(function() {
                            window.location.href = '{{ route("home") }}';
                        }, recordFoundAudio.duration * 1000); // Convert duration to milliseconds
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
<!-- Your JavaScript code -->

{{-- <script>
    $(document).ready(function() {
        // Track the last input time for barcode detection
        var lastInputTime = 0;
        
        // Track whether the input is coming from a barcode scanner
        var isBarcodeInput = false;

        // Set a threshold for considering input as coming from a barcode scanner
        var barcodeThreshold = 100;

        // Handle keyup event on the manual input field
        $('#manualInput').keyup(function() {
            isBarcodeInput = false;
        });

        // Handle input event on the barcode input field
        $('#barcodeInput').on('input', function() {
            isBarcodeInput = true;
        });

        // Handle keypress event on the document to detect barcode scanner input
        $(document).keypress(function(event) {
            var currentTime = new Date().getTime();

            if (currentTime - lastInputTime < barcodeThreshold) {
                // Input is coming too fast, likely from a barcode scanner
                isBarcodeInput = true;
            }

            lastInputTime = currentTime;
        });

        // Trigger the checkIn function on form submission
        $('#checkInForm').submit(function() {
            // Use the appropriate input based on the detection
            var inputField = isBarcodeInput ? $('#barcodeInput') : $('#manualInput');

            // Set the value of the hidden field to the input value
            $('input[name="student_id"]').val(inputField.val());
        });
    });
</script> --}}

@endsection
