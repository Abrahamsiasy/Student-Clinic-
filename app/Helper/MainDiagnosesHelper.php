<?php

namespace App\Helper;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MainDiagnosesHelper
{
    public function diagnosis($mainDiagnoses){
        $studentsWithDiagnoses = [];
        $diagnoses = [];
        foreach ($mainDiagnoses as $mainDiagnosis) {
            $student = $mainDiagnosis->student;
            $diagnosis = $mainDiagnosis->diagnosis;
            if(isset(Carbon::parse($student->date_of_birth)->age)){
                $studentsWithDiagnoses[] = [
                    'diagnosis' => [
                        'code' => $diagnosis->name,
                        'description' => $diagnosis->desc,
                        'age' => Carbon::parse($student->date_of_birth)->age,
                        'sex' => $student->sex,
                    ],
                ];
            }  
        }
        
        $groupedData = [];
        foreach ($studentsWithDiagnoses as $student) {
            $diagnosis = $student["diagnosis"];
            $code = $diagnosis["code"];
            $description = $diagnosis["description"];
            $sex = $diagnosis["sex"];
            $age = $diagnosis["age"];
            $age15 = 0;
            if (!isset($groupedData[$code])) {
                $groupedData[$code] = [
                    "description" => $description,
                    "code" => $code,
                    "sex_data" => [],
                ];
            }

            if (!isset($groupedData[$code]["sex_data"][$sex])) {
                $groupedData[$code]["sex_data"][$sex] = [
                    "age_data" => [],
                ];
            }

            if (!isset($groupedData[$code]["sex_data"][$sex]["age_data"][$age])) {
                $groupedData[$code]["sex_data"][$sex]["age_data"][$age] = 0;
            }

            $groupedData[$code]["sex_data"][$sex]["age_data"][$age]++;
        }
        $x = 0;
        foreach ($groupedData as $data) {
            
            $diagnoses[$x] = [
                "description" => $data['description'],
                "code" => $data['code'],
                "sex_data" => [],
            ];

            $diagnoses[$x]['sex_data']['M'] = ['15' => 0, '30' => 0, '65' => 0];

            $diagnoses[$x]['sex_data']['F'] = ['15' => 0, '30' => 0, '65' => 0];
            $age_ranges = array(
                array(15, 29),
                array(30, 65),
                array(65, 100),
            );
            
            if (isset($data['sex_data']['M'])) {
                foreach ($data['sex_data']['M'] as $agee) {
                    foreach ($age_ranges as $age_range) {
                        $count = 0;
                        foreach ($agee as $age => $value) {
                            if ($age >= $age_range[0] && $age <= $age_range[1]) {
                                $count += $value;
                            }
                        }
                        // echo "Age range " . $age_range[0] . "-" . $age_range[1] . ": " . $count . PHP_EOL;
                        if ($age_range[0] == 15) {
                            $diagnoses[$x]['sex_data']['M']['15'] = $count;
                        } elseif ($age_range[0] == 30) {
                            $diagnoses[$x]['sex_data']['M']['30'] = $count;
                        } elseif ($age_range[0] == 65) {
                            $diagnoses[$x]['sex_data']['M']['65'] = $count;
                        }
                    }
                }
            }
            if (isset($data['sex_data']['F'])) {
                foreach ($data['sex_data']['F'] as $agee) {
                    foreach ($age_ranges as $age_range) {
                        $count = 0;
                        foreach ($agee as $age => $value) {
                            if ($age >= $age_range[0] && $age <= $age_range[1]) {
                                $count += $value;
                            }
                        }
                        // echo "Age range " . $age_range[0] . "-" . $age_range[1] . ": " . $count . PHP_EOL;
                        if ($age_range[0] == 15) {
                            $diagnoses[$x]['sex_data']['F']['15'] = $count;
                        } elseif ($age_range[0] == 30) {
                            $diagnoses[$x]['sex_data']['F']['30'] = $count;
                        } elseif ($age_range[0] == 65) {
                            $diagnoses[$x]['sex_data']['F']['65'] = $count;
                        }
                    }
                }
            }
            $x++;
        }
        return $diagnoses;
    }
}