<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Patient Sick Leave</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 100px; /* Adjust as needed */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/logo/logo.jpg') }}" style="width: auto; height: 80px;" alt="Logo" class="logo">
        <h4>Patient Sick Leave</h4>
        <hr>
    </div>

    <table>
        <tr>
            <td>Name:</td>
            <td>{{ $encounter->student->fullName }}</td>
        </tr>
        <tr>
            <td>Student ID:</td>
            <td>{{ $encounter->student->id_number  ?? '-' }}</td>
        </tr>
        <tr>
            <td>Date of Examination:</td>
            <td>{{ $encounter->created_at?->format('d M Y') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Diagnosis:</td>
            <td>{{ $encounter->diagnosis ?? '-' }}
            
            
                @if($encounter->mainDiagnoses)
                @foreach ($encounter->mainDiagnoses  as  $maindiagnosis)
                
                    <tr>

                        <td> {{ $loop->index + 1 }} </td>
                   
                        <td>{{ $maindiagnosis->diagnosis->name ?? '-' }}
                        </td>
                      
                    </tr>
                @endforeach
                @endif

            
            </td>
        </tr>
        <tr>
            <td>Sick leave:</td>
            <td>{{ $encounter->sick_leave ?? '-' }}</td>
        </tr>
        <tr>
            <td>Date of appointment:</td>
            <td>{{ $encounter->date_of_appointment }}</td>
        </tr>
    </table>

    <p>Signature: _____________________</p>

    <p>Name of physician: {{ $encounter->doctor->name }}</p>

    <!-- Add other sick leave information as needed -->

</body>
</html>
