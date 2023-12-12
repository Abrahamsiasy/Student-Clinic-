{{-- <table>
    <thead>
        <tr>
            <th colspan="15">Health Facility Monthly OPD Service Report
                Form</th>
        </tr>
        <tr>
            <th colspan="15">
                Zone ____ Woreda ___ Name of Health Facility ___Jumc healt center__Year_______ Month_______ Date
                ____________
            </th>
        </tr>
        <tr>
            <th rowspan="2">S.No</th>
            <th rowspan="2">National classification of Disease(NCoD)</th>
            <th rowspan="2">Min. NCoD Code</th>
            <th colspan="6">Male</th>
            <th colspan="6">Female</th>
        </tr>
        <tr>
            <th >
                <1 yr</th>
            <th>1-4 yrs</th>
            <th>5-14 yrs</th>
            <th>15-29 yrs</th>
            <th>30-64 yrs</th>
            <th>>=65 yrs</th>
            <th>
                <1 yr</th>
            <th>1-4 yrs</th>
            <th>5-14 yrs</th>
            <th>15-29 yrs</th>
            <th>30-64 yrs</th>
            <th>>=65 yrs</th>
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
                        {{ $diagnosisData['sex_data']['M']['15'] }}
                    @endif
                </td>
                <td>
                    @if ($diagnosisData['sex_data']['M']['30'])
                        {{ $diagnosisData['sex_data']['M']['30'] }}
                    @endif
                </td>
                <td>
                    @if ($diagnosisData['sex_data']['M']['65'])
                        {{ $diagnosisData['sex_data']['M']['65'] }}
                    @endif
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    @if ($diagnosisData['sex_data']['F']['15'])
                        {{ $diagnosisData['sex_data']['F']['15'] }}
                    @endif
                </td>
                <td>
                    @if ($diagnosisData['sex_data']['F']['30'])
                        {{ $diagnosisData['sex_data']['F']['30'] }}
                    @endif
                </td>
                <td>
                    @if ($diagnosisData['sex_data']['F']['65'])
                        {{ $diagnosisData['sex_data']['F']['65'] }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<table>
    <tbody>
        <thead>
            <tr>
                <th >Health Facility Monthly OPD Service Report
                    Form</th>
            </tr>
            {{-- <tr>
                <th colspan="15">
                    Zone ____ Woreda ___ Name of Health Facility ___Jumc healt center__Year_______ Month_______ Date
                    ____________
                </th>
            </tr>
            <tr>
                <th rowspan="2">S.No</th>
                <th rowspan="2">National classification of Disease(NCoD)</th>
                <th rowspan="2">Min. NCoD Code</th>
                <th colspan="6">Male</th>
                <th colspan="6">Female</th>
            </tr>
            <tr>
                <th >
                    <1 yr</th>
                <th>1-4 yrs</th>
                <th>5-14 yrs</th>
                <th>15-29 yrs</th>
                <th>30-64 yrs</th>
                <th>>=65 yrs</th>
                <th>
                    <1 yr</th>
                <th>1-4 yrs</th>
                <th>5-14 yrs</th>
                <th>15-29 yrs</th>
                <th>30-64 yrs</th>
                <th>>=65 yrs</th>
            </tr> --}}
        </thead>
        <tbody>

        </tbody>
    </tbody>
  </table>
