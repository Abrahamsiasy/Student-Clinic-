@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card m-3 p-3">
            <!-- Content Wrapper. Contains page content -->
            <!-- Content Header (Page header) -->
            <div class="row justify-content-center align-items-center">
                <img src="https://upload.wikimedia.org/wikipedia/en/f/fe/Current_Logo_of_Jimma_University.png" alt="JU Logo"
                    class="brand-image img-fluid" style="max-width: 100px; width: 100%;">
            </div>
            <h2 class="text-center">Medical Sick Leave Letter</h2>


            <!-- Main content -->
            <div class="container">
                <div class="card card-primary card-outline">

                    <div class="card-body">
                        <!-- Rest of your content -->
                        {{-- @dd($medicalSickLeaves) --}}

                        <div class="container mt-4">
                            <h3>Medical Information</h3>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Patient Name</th>
                                        <td>{{ optional($medicalSickLeaves?->student)?->first_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Student ID</th>
                                        <td>{{ optional($medicalSickLeaves?->student)?->id_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date Of Examination</th>
                                        <td> {{ optional($medicalSickLeaves?->encounter)->accepted_at ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Diagnosis</th>
                                        <td> {{ optional($medicalSickLeaves?->encounter?->mainDiagnoses)?->first()->name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Arrived At</th>
                                        <td> {{ optional($medicalSickLeaves?->encounter)->created_at ?? '-' }}</td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sick Leave</th>
                                        <td>Example</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Appointment</th>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="form-group">
                                <label for="signature">Signature____________________</label>

                            </div>

                            <table class="form-group">

                                <th scope="row ">Name of Physician</th>
                                <td class="px-4" style="text-decoration: underline;">
                                    {{ optional($medicalSickLeaves?->encounter?->Doctor)?->name ?? '-' }}</td>
                            </table>

                        </div>


                    </div>
                    <footer class="main-footer">
                        <div class="container text-center">
                            <?php
                            $now = Carbon\Carbon::now();
                            ?>

                            Date:[{{ $now->format('Y-m-d') }}]
                        </div>
                    </footer>
                </div>
                <!-- /.content-wrapper -->

                <!-- Main Footer -->

                <!-- Print Button -->
                <button type="button" class="btn btn-sm btn-outline-primary mx-1" onclick="printSickLeave()">
                    <i class="fas fa-print"></i> Print
                </button>

            </div>
            <!-- ./wrapper -->

            <!-- Print Button -->
            <script>
                function printSickLeave() {
                    // Hide the print button to prevent it from being included in the printed document
                    const printButton = document.querySelector('button');
                    printButton.style.display = 'none';

                    // Trigger the browser's print dialog
                    window.print();

                    // Show the print button again after printing is done (use setTimeout to ensure it shows even if the print dialog is canceled)
                    setTimeout(function() {
                        printButton.style.display = 'block';
                    }, 100);
                }
            </script>

        </div>
    </div>
@endsection
