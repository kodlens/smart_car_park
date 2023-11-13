<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Learner;
use Illuminate\Validation\Rule;


class ManageLearnerController extends Controller
{
    //


    public function index(){
        return view('administrator.manage-learner.manage-learner');
    }


    public function getLearners(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Learner::with(['track', 'strand'])
            ->where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function create(){
        return view('administrator.manage-learner.manage-learner-create-edit')
            ->with('id', 0)
            ->with('data', '');
    }

    public function edit($id){
        $data = Learner::with([
            'current_province', 
            'current_city',
            'current_barangay',
            'permanent_province', 
            'permanent_city',
            'permanent_barangay',
            'track', 
            'strand'])
            ->where('learner_id', $id)
            ->first();


        return view('administrator.manage-learner.manage-learner-create-edit')
            ->with('id', $data->learner_id)
            ->with('data', $data);
    }


    public function store(Request $req){

        $req->validate([

            'grade_level' => ['required'],
            'is_returnee' => ['required'],

            'lname' => ['required', 'string', 'max:50'],
            'fname' => ['required', 'string', 'max:50'],
            'sex' => ['required', 'string', 'max:10'],
            'birthdate' => ['required'],
            
            'age' => ['required'],
            'mother_tongue' => ['required'],

            'current_province' => ['required'],
            'current_city' => ['required'],
            'current_barangay' => ['required'],
            'current_zipcode' => ['max:15'],

            'guardian_lname' => ['required'],
            'guardian_fname' => ['required'],
            'guardian_contact_no' => ['required', 'regex:/^(09|\+639)\d{9}$/'],

            'if_yes_indigenous' => Rule::requiredIf(function () use ($req){
                return $req->is_indigenous == 1 ? true : false;
            }),
            'household_4ps_id_no' => Rule::requiredIf(function () use ($req){
                return $req->is_4ps == 1 ? true : false;
            }),

            //==================================================================================//
            //=-----------if senior high school required this fields-----------------=//
            'semester_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            'senior_high_school_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            'track_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            'strand_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            /* ==================================== */
            /* end required fields if senior highschool */
            /* required if returnee*/
            'last_grade_level_completed' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
            'last_school_year_completed' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
            'last_school_attended' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
            'last_schoold_id' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
        ],[
            'guardian_contact_no.regex' => 'Please enter a valid Philippines mobile phone number.',
            'if_yes_indigenous.required' => 'This field is required since you belong to indigenous.',
            'household_4ps_id_no.required' => 'This field is required since you are a 4ps member.',

            'semester_id.required' => 'This field is required since you are a senior high.',
            'senior_high_school_id.required' => 'This field is required since you are a senior high.',
            'track_id.required' => 'This field is required since you are a senior high.',
            'strand_id.required' => 'This field is required since you are a senior high.',
            
            'last_grade_level_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_year_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_attended.required' => 'This field is required since you are a returnee student.',
            'last_schoold_id.required' => 'This field is required since you are a returnee student.'

        ]);
        /* if not a senior high, set default value */
        $semesterId = 0;
        $trackId = 0;
        $strandId = 0;
        $seniorHighSchoolId = '';
        if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
            $semesterId = $req->semester_id;
            $trackId = $req->track_id;
            $strandId = $req->strand_id;
            $seniorHighSchoolId = $req->senior_high_school_id;
        }
        /* end setting default value for senior high */


        /* if not a returnee setup default data */
        $lastGradeLevelCompleted = null;
        $lastSchoolYearCompleted = null;
        $lastSchoolAttended = null;
        $lastSchoolId = null;
        if($req->is_returnee > 0){

            $lastGradeLevelCompleted = strtoupper($req->last_grade_level_completed);
            $lastSchoolYearCompleted = strtoupper($req->last_school_year_completed);
            $lastSchoolAttended = strtoupper($req->last_school_attended);
            $lastSchoolId = strtoupper($req->last_schoold_id);
        }
        /* ===========END=============== */


        /*inserting data to database*/
        $data = Learner::create([

            'grade_level' => $req->grade_level,
            'is_returnee' => $req->is_returnee,

            'psa_cert' => $req->psa_cert,
            'lrn' => $req->lrn,
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'extension' => strtoupper($req->suffix),
            'sex' => $req->sex,
            'birthdate' => date('Y-m-d', strtotime($req->birthdate)),
            'age' => $req->age,
            'birthplace' => strtoupper($req->birthplace),

            'mother_tongue' => strtoupper($req->mother_tongue),
            'is_indigenous' => $req->is_indigenous,
            'if_yes_indigenous' => $req->is_indigenous ? $req->if_yes_indigenous : null,
            'is_4ps' => $req->is_4ps,
            'household_4ps_id_no' => $req->is_4ps ? $req->household_4ps_id_no : null,

            'current_province' => $req->current_province,
            'current_city' => $req->current_city,
            'current_barangay' => $req->current_barangay,
            'current_street' => strtoupper($req->current_street),
            'current_zipcode' => $req->current_zipcode,

            'permanent_province' => $req->permanent_province,
            'permanent_city' => $req->permanent_city,
            'permanent_barangay' => $req->permanent_barangay,
            'permanent_street' => strtoupper($req->permanent_street),
            'permanent_zipcode' => $req->permanent_zipcode,

            //'email' => $req->email,
            //'contact_no' => $req->contact_no,

            'father_lname' => strtoupper($req->father_lname),
            'father_fname' => strtoupper($req->father_fname),
            'father_mname' => strtoupper($req->father_mname),
            'father_extension' => strtoupper($req->father_mname),
            'father_contact_no' => $req->father_contact_no,

            'mother_maiden_lname' => strtoupper($req->mother_maiden_lname),
            'mother_maiden_fname' => strtoupper($req->mother_maiden_fname),
            'mother_maiden_mname' => strtoupper($req->mother_maiden_mname),
            'mother_maiden_contact_no' => $req->mother_maiden_contact_no,

            'guardian_lname' => strtoupper($req->guardian_lname),
            'guardian_fname' => strtoupper($req->guardian_fname),
            'guardian_mname' => strtoupper($req->guardian_mname),
            'guardian_extension' => strtoupper($req->guardian_mname),
            'guardian_contact_no' => $req->guardian_contact_no,


            'last_grade_level_completed' => $lastGradeLevelCompleted,
            'last_school_year_completed' => $lastSchoolYearCompleted,
            'last_school_attended' => $lastSchoolAttended,
            'last_schoold_id' => $lastSchoolId,

            
            'semester_id' => $semesterId,
            'senior_high_school_id' => $seniorHighSchoolId,
            'track_id' => $trackId,
            'strand_id' => $strandId,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    
    public function update(Request $req, $id){

        $req->validate([

            'grade_level' => ['required'],
            'is_returnee' => ['required'],

            'lname' => ['required', 'string', 'max:50'],
            'fname' => ['required', 'string', 'max:50'],
            'sex' => ['required', 'string', 'max:10'],
            'birthdate' => ['required'],
            
            'age' => ['required'],
            'mother_tongue' => ['required'],

            'current_province' => ['required'],
            'current_city' => ['required'],
            'current_barangay' => ['required'],
            'current_zipcode' => ['max:15'],

            'guardian_lname' => ['required'],
            'guardian_fname' => ['required'],
            'guardian_contact_no' => ['required', 'regex:/^(09|\+639)\d{9}$/'],

            'if_yes_indigenous' => Rule::requiredIf(function () use ($req){
                return $req->is_indigenous == 1 ? true : false;
            }),
            'household_4ps_id_no' => Rule::requiredIf(function () use ($req){
                return $req->is_4ps == 1 ? true : false;
            }),

            //==================================================================================//
            //=-----------if senior high school required this fields-----------------=//
            'semester_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            'senior_high_school_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            'track_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            'strand_id' => Rule::requiredIf(function () use ($req){
                if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
                    return true;
                }else{
                    return false;
                }
            }),
            /* ==================================== */
            /* end required fields if senior highschool */
            /* required if returnee*/
            'last_grade_level_completed' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
            'last_school_year_completed' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
            'last_school_attended' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
            'last_schoold_id' => Rule::requiredIf(function () use ($req){
                if($req->is_returnee == 1){
                    return true;
                }else{
                    return false;
                }
            }),
        ],[
            'guardian_contact_no.regex' => 'Please enter a valid Philippines mobile phone number.',
            'if_yes_indigenous.required' => 'This field is required since you belong to indigenous.',
            'household_4ps_id_no.required' => 'This field is required since you are a 4ps member.',

            'semester_id.required' => 'This field is required since you are a senior high.',
            'senior_high_school_id.required' => 'This field is required since you are a senior high.',
            'track_id.required' => 'This field is required since you are a senior high.',
            'strand_id.required' => 'This field is required since you are a senior high.',
            
            'last_grade_level_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_year_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_attended.required' => 'This field is required since you are a returnee student.',
            'last_schoold_id.required' => 'This field is required since you are a returnee student.'

        ]);
        /* if not a senior high, set default value */
        $semesterId = 0;
        $trackId = 0;
        $strandId = 0;
        $seniorHighSchoolId = '';
        if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
            $semesterId = $req->semester_id;
            $trackId = $req->track_id;
            $strandId = $req->strand_id;
            $seniorHighSchoolId = $req->senior_high_school_id;
        }
        /* end setting default value for senior high */


        /* if not a returnee setup default data */
        $lastGradeLevelCompleted = null;
        $lastSchoolYearCompleted = null;
        $lastSchoolAttended = null;
        $lastSchoolId = null;
        if($req->is_returnee > 0){

            $lastGradeLevelCompleted = strtoupper($req->last_grade_level_completed);
            $lastSchoolYearCompleted = strtoupper($req->last_school_year_completed);
            $lastSchoolAttended = strtoupper($req->last_school_attended);
            $lastSchoolId = strtoupper($req->last_schoold_id);
        }
        /* ===========END=============== */


        /*inserting data to database*/
        $data = Learner::where('learner_id', $id)
            ->update([

                'grade_level' => $req->grade_level,
                'is_returnee' => $req->is_returnee,

                'psa_cert' => $req->psa_cert,
                'lrn' => $req->lrn,
                'lname' => strtoupper($req->lname),
                'fname' => strtoupper($req->fname),
                'mname' => strtoupper($req->mname),
                'extension' => strtoupper($req->suffix),
                'sex' => $req->sex,
                'birthdate' => date('Y-m-d', strtotime($req->birthdate)),
                'age' => $req->age,
                'birthplace' => strtoupper($req->birthplace),

                'mother_tongue' => strtoupper($req->mother_tongue),
                'is_indigenous' => $req->is_indigenous,
                'if_yes_indigenous' => $req->is_indigenous ? $req->if_yes_indigenous : null,
                'is_4ps' => $req->is_4ps,
                'household_4ps_id_no' => $req->is_4ps ? $req->household_4ps_id_no : null,

                'current_province' => $req->current_province,
                'current_city' => $req->current_city,
                'current_barangay' => $req->current_barangay,
                'current_street' => strtoupper($req->current_street),
                'current_zipcode' => $req->current_zipcode,

                'permanent_province' => $req->permanent_province,
                'permanent_city' => $req->permanent_city,
                'permanent_barangay' => $req->permanent_barangay,
                'permanent_street' => strtoupper($req->permanent_street),
                'permanent_zipcode' => $req->permanent_zipcode,

                //'email' => $req->email,
                //'contact_no' => $req->contact_no,

                'father_lname' => strtoupper($req->father_lname),
                'father_fname' => strtoupper($req->father_fname),
                'father_mname' => strtoupper($req->father_mname),
                'father_extension' => strtoupper($req->father_mname),
                'father_contact_no' => $req->father_contact_no,

                'mother_maiden_lname' => strtoupper($req->mother_maiden_lname),
                'mother_maiden_fname' => strtoupper($req->mother_maiden_fname),
                'mother_maiden_mname' => strtoupper($req->mother_maiden_mname),
                'mother_maiden_contact_no' => $req->mother_maiden_contact_no,

                'guardian_lname' => strtoupper($req->guardian_lname),
                'guardian_fname' => strtoupper($req->guardian_fname),
                'guardian_mname' => strtoupper($req->guardian_mname),
                'guardian_extension' => strtoupper($req->guardian_mname),
                'guardian_contact_no' => $req->guardian_contact_no,

                'last_grade_level_completed' => $lastGradeLevelCompleted,
                'last_school_year_completed' => $lastSchoolYearCompleted,
                'last_school_attended' => $lastSchoolAttended,
                'last_schoold_id' => $lastSchoolId,

                'semester_id' => $semesterId,
                'senior_high_school_id' => $seniorHighSchoolId,
                'track_id' => $trackId,
                'strand_id' => $strandId,
            ]);

        return response()->json([
            'status' => 'updated'
        ],200);
    }


}
