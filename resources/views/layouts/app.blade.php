

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JU-SIS-V2</title>


    <style>
        html {
            background-color: #f4f6f9;
        }

        .nav-icon.icon:before {
            width: 25px;
        }

         .select2-selection {
          height: auto !important;
          }

        /* * {
            outline: 1px solid red;
        } */
    </style>

    

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <!-- Additional Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/bootstrap-duallistbox.css"
        integrity="sha512-8TCY/k+p0PQ/9+htlHFRy3AVINVaFKKAxZADSPH3GSu3UWo2eTv9FML0hJZrvNQbATtPM4fAw3IS31Yywn91ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js" defer></script>

    <!-- CKE Editor -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Additional Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @stack('styles')

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed">
    <div id="app" class="wrapper">
        <div class="main-header">
            @include('layouts.nav')
        </div>

        @include('layouts.sidebar')

        <main class="content-wrapper p-5">
            @yield('content')
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    @stack('scripts')

    <!-- Custom Scripts -->
    <script>
        // Your custom scripts here
    </script>

    <!-- Conditional Notyf -->
    @if (session()->has('success') || session()->has('error'))
        <script>
            // Notyf initialization and usage
            var notyf = new Notyf({
                dismissible: true,
                position: {
                    x: 'right',
                    y: 'top',
                },
                width: '500px', // Set the desired width here
            });

            @if (session()->has('success'))
                notyf.success('{{ session('success') }}');
            @elseif (session()->has('error'))
                notyf.error('{{ session('error') }}');
            @endif
        </script>
    @endif

    <!-- Alpine Image Viewer -->
    <script>
        // Alpine Image Viewer script
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', (src = '') => {
                return {
                    imageUrl: src,

                    refreshUrl() {
                        this.imageUrl = this.$el.getAttribute("image-url")
                    },

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            })
        })

        $(document).ready(function($) {
            $('.select2').select2();
        });


        //     $(document).ready(function() {
        //         $('#select2').select2();
        //     });
        // 
    </script>

    <!-- Delete Confirmation with SweetAlert -->
    <script>
        // Delete confirmation script
        $(document).on('submit', '#deletebtnid', function(e) {
            e.preventDefault();

            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover it.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            url: $(this).data('route'),
                            data: {
                                '_method': 'delete'
                            },
                            success: function(response) {
                                swal("DELETED SUCCESFULLY", {
                                    icon: "success",
                                    button: true,

                                }).then((ok) => {
                                    window.location = window.location.pathname
                                })

                            }
                        });


                    } else {

                    }
                });
        });

        function checkBoxes(labelNames) {
            const substrings = labelNames.split(',').map(substring => substring.trim());
            const labels = document.querySelectorAll('label');
            labels.forEach(label => {
                const labelText = label.textContent;
                substrings.forEach(substring => {
                    if (labelText.includes(substring)) {
                        const checkboxId = label.getAttribute('for');
                        const checkbox = document.getElementById(checkboxId);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                });
            });
        }
    </script>
</body>

</html>
