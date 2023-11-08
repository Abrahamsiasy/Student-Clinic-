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
                    <p>
                        {{-- {{ $encounter->first()->Doctor ? $encounter->first()->Doctor->user->name : '-' }} --}}
                        {{ $encounter->Doctor ? $encounter->Doctor->user->name : '-' }}

                        {{-- {{ dd($opdQueue->first()->Doctor->rooms->first()->name) }} --}}

                    </p>

                </div>
                <div class="icon">
                    <i class="ion ion-stat text-light font-weight-bold"><span class="small text-md">

                            <?php
                            
                            // PHP code goes here
                            $string = $encounter->Doctor ? $encounter->Doctor->room->name ?? '-' : '-';
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
