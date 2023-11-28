<div class="row m-2">

    <?php
    // Array of possible background colors
    $bgColors = ['bg-info', 'bg-success', 'bg-warning', 'bg-primary', 'bg-secondary'];
    
    // Shuffle the array to randomize the color order
    shuffle($bgColors);
    ?>

    @foreach ($opdQueue as $index => $encounter)
        <?php
        // Get a random background color from the shuffled array
        $bgColor = $bgColors[$index % count($bgColors)];
        ?>

        <div class="col-lg-6">
            <div class="small-box {{ $bgColor }}">
                <div class="inner">
                    {{-- @dump($encounter) --}}
                    <h3>{{ $encounter->student->id_number ?? '-' }}</h3>
                    <div class="d-flex justify-content">
                        <p>
                          Called at  {{ $encounter->updated_at->diffForHumans() }} 
                        </p>
                        {{-- <p class="px-2">
                        
                            <span id="timeCounter" class="right badge badge-danger">
                                @if ($encounter->accepted_at)
                                    @php
                                        $acceptedTime = \Carbon\Carbon::parse($encounter->accepted_at);
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
                                    No accepted time available.
                                @endif
                            </span>



                        </p> --}}
                    </div>
                </div>
                <div class="icon">
                    <i class="ion ion-stat text-light font-weight-bold"><span class="small text-md">

                            <?php
                            
                            // PHP code goes here
                            $string = $encounter->Doctor ? $encounter->Doctor->clinicUsers->room->name ?? '-' : '-';
                            $number = preg_replace('/[^0-9]/', '', $string) ?? '-';
                            $letters = preg_replace('/[^a-zA-Z]/', '', $string) ?? '-';
                            ?>
                            {{ $letters }}</span>{{ $number }}</i>
                </div>
                <h5 class="small-box-footer">
                    {{ $encounter->student ? $encounter->student->getFullNameAttribute() : '_' }} <i
                        class="fas fa-arrow-circle-right"></i>
                </h5>
            </div>
        </div>
    @endforeach
</div>
