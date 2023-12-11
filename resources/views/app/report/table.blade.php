<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    
    <table>
        <thead>
            <tr>
                <th colspan="15"  style="text-align:center;font-size: 19px;">Health Facility Monthly OPD Service Report Form</th>
            </tr>
            <tr>
                <th colspan="15"  style="text-align:center;">
                    Zone ____  Woreda  ___  Name of  Health Facility ___Jumc healt center__Year_______ Month_______  Date ____________
                </th>
            </tr>
            <tr>
                <th rowspan="2">S.No</th>
                <th rowspan="2">National classification of Disease(NCoD)</th>
                <th rowspan="2">Min. NCoD Code</th>
                <th colspan="6"  style="background:#d2d6de;text-align: center">Male</th>
                <th colspan="6"  style="background:#a8c7fa;text-align: center">Female</th>
            </tr>
            <tr >
                <th style="background:#d2d6de">
                    <1 yr</th>
                <th style="background:#d2d6de">1-4 yrs</th>
                <th style="background:#d2d6de">5-14 yrs</th>
                <th style="background:#d2d6de">15-29 yrs</th>
                <th style="background:#d2d6de">30-64 yrs</th>
                <th style="background:#d2d6de">>=65 yrs</th>
                <th style="background:#a8c7fa">
                    <1 yr</th>
                <th style="background:#a8c7fa">1-4 yrs</th>
                <th style="background:#a8c7fa">5-14 yrs</th>
                <th style="background:#a8c7fa">15-29 yrs</th>
                <th style="background:#a8c7fa">30-64 yrs</th>
                <th style="background:#a8c7fa">>=65 yrs</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($diagnoses as $code => $diagnosisData)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diagnosisData['code'] }}</td>
                    <td>{{ $diagnosisData['description'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        @if ($diagnosisData['sex_data']['M']['15'])
                            {{$diagnosisData['sex_data']['M']['15']}} 
                        @endif
                    </td>
                    <td>
                        @if ($diagnosisData['sex_data']['M']['30'])
                            {{$diagnosisData['sex_data']['M']['30']}} 
                        @endif
                    </td>
                    <td>
                        @if ($diagnosisData['sex_data']['M']['65'])
                            {{$diagnosisData['sex_data']['M']['65']}} 
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        @if ($diagnosisData['sex_data']['F']['15'])
                            {{$diagnosisData['sex_data']['F']['15']}} 
                        @endif
                    </td>
                    <td>
                        @if ($diagnosisData['sex_data']['F']['30'])
                            {{$diagnosisData['sex_data']['F']['30']}} 
                        @endif
                    </td>
                    <td>
                        @if ($diagnosisData['sex_data']['F']['65'])
                            {{$diagnosisData['sex_data']['F']['65']}} 
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
