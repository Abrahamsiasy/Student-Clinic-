<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JU Gate Control</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini" style="background-color: #eeeeee">
    <div class="wrapper">
        <section class="content">

            <div class="card card-solid">

                <div class="card-header" style="background-color: #0067b8 !important">
                    <h5 class="card-titlen text-secondary"
                        style="margin-top: 4px; margin-bottom: 0px;display:inline; margin-right:20px;font-size:2rem;font-weight:100">
                        <a href="#">
                            <img class="mr-2" src="https://ju.edu.et/wp-content/uploads/2022/12/main-logo.png"
                                width="213px" height="auto" alt="logo">
                        </a>
                    </h5>
                    <form action="{{ route('search.student') }}" method="POST" id="search-stud"
                        class="form-inline ml-0 ml-md-3" style="display:none">
                        @csrf
                        <div class="input-group ">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                id="id_number" name="id_number" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit"
                                    style="background-color: #fff;
                                        border: 1px solid #ced4da;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="card-tools">
                        <h5 class="card-title text-white"
                            style="margin-top: 4px; margin-bottom: 0px;display:inline; margin-right:20px;font-size:2rem;font-weight:100"
                            id="time">

                        </h5>
                        <h5
                            style="
                            margin-top: 12px;
                            margin-bottom: 0px;
                            color: #fff;
                            /* background-color: #6288c6; */
                            /* border-color: #6288c6; */
                            display: inline-block;
                            ">
                            <i class="fas fa-school mr-2"></i>
                            {{ $gate->gate_name }}
                        </h5>
                    </div>
                </div>

                {{-- check in start --}}
                <div class="card-body row" style="background-color:#eeeeee" id="checkIn">
                    <div class="col text-center d-flex align-items-center justify-content-center mt-5">
                        <div class="">
                            <h2 class="text-center display-4 text-danger">Scan your ID</h2>
                            <p class="lead mb-5 text-black text-center" style="font-weight: 400;">
                                Student ID verification required
                                for gate entry Please present your ID card for scanning if you are currently enrolled.
                                <br>For further assistantce, kindly inquire with the gate police.
                            </p>
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    {{-- <form> --}}
                                    <div class="input-group">
                                        <input type="search" class="form-control form-control-lg" id="scannID"
                                            placeholder="student ID number" onsearch="searchStudent()">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-lg btn-default"
                                                onclick="searchStudent()">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <div class="text-center">

                                <img class="text-align " src="{{ asset('assets/gate-scanner.png') }}" alt="">

                            </div>
                        </div>
                    </div>

                </div>

                <div class="container-fluid">
                    <div class="card-body" style="background-color: #eeeeee;display:none" id="detail-card">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div id="profile_img" class="col-12"
                                    style="height: 720px;background-position: center;background-repeat: no-repeat;background-size: cover;">

                                </div>

                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="bg-gray" style="border-radius:50px; background-color:#ffffff !important">
                                    <div id="full-name-border-color" class="position-relative p-3 bg-gray"
                                        style="height:180px;border-radius:10px; background-color:#ffffff !important;">
                                        <div class="ribbon-wrapper ribbon-xl"
                                            style="
                                        height: 180px;
                                        width: 180px;
                                        top:unset;">


                                            <div class="ribbon  text-xl" id="check-img"
                                                style="
                                                right: -2px;
                                                top: 20px;
                                                width: 142px;
                                                height: 140px;
                                                border-radius: 136px;
                                                -webkit-transform: unset;
                                                transform: unset;
                                                padding:unset;
                                                /* background-color: #37e030; */
                                                /* background-image:url('{{ asset('assets/check-success.png') }}'); */
                                                position:unset;
                                                background-repeat: round;
                                                box-shadow: unset;">
                                            </div>

                                        </div>
                                        <h1 class="mb-0" id="full_name"
                                            style="color: black;text-align:center;margin-top: 30px">
                                        </h1>
                                        <h3 class="mt-0" style="text-align:center;">
                                            <small style="color: black"><i class="far fa-id-card"></i></small>
                                            <small id="id_num" style="color: black"></small>
                                        </h3>
                                        {{-- <small>.ribbon-wrapper.ribbon-xl .ribbon.text-xl</small> --}}
                                    </div>
                                </div>
                                <div id="under-fullname"
                                    style="
                        border-bottom-right-radius: 40px;
                        border-bottom-left-radius: 40px;
                        height: 18px;
                        padding-left: 0px;
                        border-left-width: 0px;
                        margin-left: 31px;
                        margin-right: 31px;
                        /* background-color:#84cf06; */
                    ">
                                </div>

                                <div class="card-body p-0 mt-3">
                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        <li class="item" style="background-color: #eeeeee">
                                            <div class="product-img">
                                                <i class="fas fa-university fa-lg mr-2"
                                                    style="font-size: 3rem;margin-top: 4px;color:gray"></i>
                                                {{-- <img src="" alt="Product Image" class="img-size-50"> --}}
                                            </div>
                                            <div class="product-info">
                                                <span class="product-title">Campus
                                                </span>
                                                <span class="product-description" id="program">

                                                </span>
                                            </div>
                                        </li>
                                        <li class="item" style="background-color: #eeeeee">
                                            <div class="product-img">
                                                <i class="fas fa-stream fa-lg mr-2"
                                                    style="font-size: 2.5rem;margin-top: 4px;margin-left: 4px;color:gray"></i>
                                                {{-- <img src="" alt="Product Image" class="img-size-50"> --}}
                                            </div>
                                            <div class="product-info">
                                                <span class="product-title">Department
                                                </span>
                                                <span class="product-description" id="program">

                                                </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <li class="item" style="background-color: #eeeeee">
                                            <div class="product-img">
                                                <i class="fas fa-calendar-alt fa-lg mr-2"
                                                    style="font-size: 2.7rem;margin-top: 6px;margin-left: 5px;;color:gray"></i>
                                                {{-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> --}}
                                            </div>
                                            <div class="product-info">
                                                <span class="product-title">Year
                                                </span>
                                                <span class="product-description" id="year">

                                                </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <li class="item" style="background-color: #eeeeee">
                                            <div class="product-img">
                                                <i class="fas fa-laptop fa-lg mr-2"
                                                    style="font-size: 2.4rem;margin-top: 11px;color:gray"></i>
                                                {{-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> --}}
                                            </div>
                                            <div class="product-info">
                                                <span class="product-title">
                                                    Laptop Serial Number
                                                </span>
                                                <span class="product-description">
                                                    XXX XXX XXX
                                                </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <!-- /.item -->
                                    </ul>
                                </div>



                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/jquery.fullscreen-min.js') }}"></script>

    <script type="text/javascript">
        let countdown = 0;
        document.addEventListener("keydown", (e) => {
            if (e.key === "f") {
                $(document).fullScreen(true);
            }
        }, false);
        $(document).ready(function() {
            // $('body').fullscreen();
            $("#id_number").focus();
            $("#scannID").focus();
        });

        setInterval(fetchData, 1000);

        function fetchData() {
            $.ajax({
                url: "{{ route('check.current_data', $gate_id) }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        $('#id_number').val(response.data);
                        $('#scannID').val(response.data);
                        $('#search-stud').submit();
                        countdown = 0;
                    }
                },
                error: function() {
                    if (countdown === 50) {
                        $('#detail-card').hide()
                        $('#checkIn').show()
                        countdown = 0;
                    }
                }
            });
            countdown++;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#id_number').keyup(function() {
            if (this.value.length == 10) {
                $('#search-stud').click();
            }
        });

        $("#id_number").on("input", function() {
            if (this.value.length == 10) {
                $('#search-stud').submit();
            }

        });

        $('#search-stud').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#file-input-error').text('');

            $.ajax({
                type: 'POST',
                url: "{{ route('search.student') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response.data) {
                        $('#msg').hide();
                        $('#full_name').show();
                        $('#id_num').show();
                        $('#list-all').show();
                        $('#profile_img').show()
                        if (response) {
                            $('#detail-card').show()
                            $('#checkIn').hide()
                            $('#search-stud').css("display", 'inline-block')
                            $('#under-fullname').css("background-color", '#84cf06')
                            $('#full-name-border-color').css("border", '1px solid #84cf06')
                            src = "{{ asset('assets/check-success.png') }}"
                            $('#check-img').css("background-image", 'url(' + src + ')')
                            image = response.data.photo
                            var studimg = 'https://srs.ju.edu.et/uploads/student/' + image;
                            profile_image = studimg;
                            console.log(profile_image)
                            $('#status').attr('src', src)
                            $('#status').attr('width', '200')
                            $('#status_2').attr('src', src)
                            $('#status_2').attr('width', '200')
                            $('#profile_img').show()
                            $('#profile_img').css("background-image", 'url(' + profile_image + ')')
                            $('#full_name').html(response.data.first_name + ' ' + response.data
                                .middle_name + ' ' + response.data.last_name);
                            $('#id_num').html(response.data.id_number);
                            $('#program').html('-');
                            $('#year').html(response.data.academic_year);
                            var obj = document.createElement("audio");
                            var sound = '{{ URL::asset('assets/sound/beep-02.wav') }}';
                            obj.src = sound;
                            obj.volume = 1;
                            obj.autoPlay = false;
                            obj.preLoad = true;
                            obj.controls = true;
                            obj.play();
                            $('#id_number').val('')
                            $("#id_number").focus();
                        }
                    } else {
                        $('#detail-card').show()
                        $('#checkIn').hide()
                        $('#search-stud').css("display", 'inline-block')
                        $('#under-fullname').css("background-color", "red")
                        $('#full-name-border-color').css("border", '1px solid red')
                        src = "{{ asset('assets/check-error.png') }}"
                        $('#check-img').css("background-image", 'url(' + src + ')')
                        $('#profile_img').show()
                        profile_not_found = "{{ asset('assets/profile-notfound-img.png') }}"
                        $('#profile_img').css("background-image", 'url(' + profile_not_found + ')')

                        $('#status').attr('src', src)
                        $('#status').attr('width', '200')
                        $('#status_2').attr('src', src)
                        $('#status_2').attr('width', '200')
                        $('#full_name').html('Not Found');
                        $('#id_num').html('Not Found');
                        $('#list-all').hide();
                        // $('#profile_img').hide()
                        $('#msg').show();
                        $('#msg_2').hide()
                        var obj = document.createElement("audio");
                        var sound = '{{ URL::asset('assets/sound/error.mp3') }}';
                        obj.src = sound;
                        obj.volume = 1;
                        obj.autoPlay = false;
                        obj.preLoad = true;
                        obj.controls = true;
                        obj.play();
                        $('#id_number').val('')
                    }
                },
                error: function(response) {
                    $('#file-input-error').text(response.responseJSON.message);
                }
            });
        });

        function updateClock() {
            var now = new Date();
            var ethiopianTime = getEthiopianTime(now);
            var ethiopianHours = ethiopianTime.hours.toString().padStart(2, '0');
            var ethiopianMinutes = ethiopianTime.minutes.toString().padStart(2, '0');
            var ethiopianSeconds = ethiopianTime.seconds.toString().padStart(2, '0');

            var clock = document.getElementById('time');
            clock.textContent = ethiopianHours + ':' + ethiopianMinutes + ':' + ethiopianSeconds;

            // var day = document.getElementById('day');
            // day.textContent = getEthiopianDayOfWeek(now);

            setTimeout(updateClock, 1000); // Update the clock every second

        }

        function getEthiopianTime(date) {
            var ethiopianHours = (date.getUTCHours() + 3) % 24;
            var ethiopianMinutes = date.getUTCMinutes();
            var ethiopianSeconds = date.getUTCSeconds();

            if (ethiopianHours > 12) {
                ethiopianHours = (ethiopianHours - 12) + 6;
            }

            return {
                hours: ethiopianHours,
                minutes: ethiopianMinutes,
                seconds: ethiopianSeconds
            };
        }

        function getEthiopianDayOfWeek(date) {
            var dayOfWeek = date.getUTCDay();
            var ethiopianDays = ['እሑድ', 'ሰኞ', 'ማክሰኞ', 'ረቡዕ', 'ሐሙስ', 'ዓርብ', 'ቅዳሜ'];

            return ethiopianDays[dayOfWeek];
        }

        updateClock(); // Start the clock initially

        function searchStudent() {
            $('#id_number').val($('#scannID').val());
            $('#search-stud').submit();
        }
    </script>
</body>

</html>
