<template>
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-6 is-8-tablet">
                <form @submit.prevent="submit">

                    <div class="box">
                        <div class="box-title">
                            ENHANCED BASIC EDUCATION ENROLLMENT FORM
                        </div>

                        <div class="panel-body">

                            <!-- <div class="divider">ACCOUNT</div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Username"
                                             :type="this.errors.username ? 'is-danger':''"
                                             :message="this.errors.username ? this.errors.username[0] : ''">
                                        <b-input type="text" v-model="fields.username" placeholder="Username" 
                                            icon="account" required></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password"
                                             :type="this.errors.password ? 'is-danger':''"
                                             :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password"  v-model="fields.password"
                                            placeholder="Password" icon="lock" password-reveal
                                                required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Re-type Password">
                                        <b-input type="password" icon="lock" v-model="fields.password_confirmation" 
                                            placeholder="Re-type Password" password-reveal
                                                required></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="E-mail"
                                             :type="this.errors.email ? 'is-danger':''"
                                             :message="this.errors.email ? this.errors.email[0] : ''">
                                        <b-input type="email" v-model="fields.email" 
                                            placeholder="E-mail" icon="email"
                                                required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Contact No."
                                             :type="this.errors.contact_no ? 'is-danger':''"
                                             :message="this.errors.contact_no ? this.errors.contact_no[0] : ''">
                                        <b-input type="tel" 
                                            v-model="fields.contact_no" 
                                            pattern="^(09|\+639)\d{9}$"
                                            placeholder="Format: 09191112222" icon=""></b-input>
                                    </b-field>
                                </div>
                            </div> -->

                            <div class="divider">LEARNER INFORMATION</div>
                            
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Grade Level"
                                        expanded
                                            :type="this.errors.grade_level ? 'is-danger':''"
                                            :message="this.errors.grade_level ? this.errors.grade_level[0] : ''" >
                                        <b-select
                                            expanded
                                            icon="account" 
                                            placeholder="Grade Level" 
                                            v-model="fields.grade_level" 
                                            required>
                                            <option :value="item.grade_level" 
                                                v-for="(item, ix) in gradeLevels" :key="`g${ix}`">
                                                {{ item.grade_level }}
                                            </option>
                                        </b-select >
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Returnee (Balik-Aral)"
                                        expanded
                                        :type="this.errors.is_returnee ? 'is-danger':''"
                                        :message="this.errors.is_returnee ? this.errors.is_returnee[0] : ''">
                                        <b-select expanded
                                            required
                                            icon="account" 
                                            placeholder="Returnee (Balik-Aral)" 
                                            v-model="fields.is_returnee">
                                            <option :value="1">YES</option>
                                            <option :value="0">NO</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="PSA Birth Certificate No."
                                            :type="this.errors.psa_birth_no ? 'is-danger':''"
                                            :message="this.errors.psa_birth_no ? this.errors.psa_birth_no[0] : ''" >
                                        <b-input icon="account" placeholder="PSA Certificate No." 
                                            v-model="fields.psa_birth_no" 
                                            type="text"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="LRN"
                                            :type="this.errors.lrn ? 'is-danger':''"
                                            :message="this.errors.lrn ? this.errors.lrn[0] : ''" >
                                        <b-input icon="account" placeholder="LRN" v-model="fields.lrn" type="text"></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name"
                                            :type="this.errors.lname ? 'is-danger':''"
                                            :message="this.errors.lname ? this.errors.lname[0] : ''" >
                                        <b-input icon="account" placeholder="Last Name" v-model="fields.lname" 
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name"
                                             :type="this.errors.fname ? 'is-danger':''"
                                             :message="this.errors.fname ? this.errors.fname[0] : ''">
                                        <b-input icon="account" v-model="fields.fname" placeholder="First Name" 
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name">
                                        <b-input v-model="fields.mname" type="text" placeholder="Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Extension (Jr, III, Sr.)">
                                        <b-input type="text" v-model="fields.extension" placeholder="Extension (Jr, III, Sr.)"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Sex" expanded
                                            :type="this.errors.sex ? 'is-danger':''"
                                            :message="this.errors.sex ? this.errors.sex[0] : ''">
                                        <b-select placeholder="Sex" v-model="fields.sex" icon="account" 
                                            required expanded>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Birthdate"
                                        :type="this.errors.birthdate ? 'is-danger':''"
                                        :message="this.errors.birthdate ? this.errors.birthdate[0] : ''">
                                        <b-datepicker v-model="fields.birthdate" placeholder="Birthdate"
                                            required></b-datepicker>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Birthplace"
                                        :type="this.errors.birthplace ? 'is-danger':''"
                                        :message="this.errors.birthplace ? this.errors.birthplace[0] : ''">
                                        <b-input type="text" v-model="fields.birthplace" placeholder="Birthplace"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-2">
                                    <b-field label="Age"
                                        :type="this.errors.age ? 'is-danger':''"
                                        :message="this.errors.age ? this.errors.age[0] : ''">
                                        <b-input type="number" v-model="fields.age"
                                            max="120"
                                            placeholder="Age"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Mother Tongue"
                                        :type="this.errors.mother_tongue ? 'is-danger':''"
                                        :message="this.errors.mother_tongue ? this.errors.mother_tongue[0] : ''">
                                        <b-input type="text" v-model="fields.mother_tongue" placeholder="Mother Tongue"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Belong in Indigenous Peoples?"
                                        :type="this.errors.is_indigenous ? 'is-danger':''"
                                        :message="this.errors.is_indigenous ? this.errors.is_indigenous[0] : ''"
                                        expanded>
                                        <b-select v-model="fields.is_indigenous" 
                                            placeholder="Belong in Indigenous Peoples?" expanded>
                                            <option :value="1">YES</option>
                                            <option :value="0">NO</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column" v-if="fields.is_indigenous == 1">
                                    <b-field label="If YES, Please specify"
                                        :type="this.errors.if_yes_indigenous ? 'is-danger':''"
                                        :message="this.errors.if_yes_indigenous ? this.errors.if_yes_indigenous[0] : ''">
                                        <b-input type="text" v-model="fields.if_yes_indigenous" placeholder="If YES, Please specify"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Beneficiary of 4Ps?"
                                        :type="this.errors.is_4ps ? 'is-danger':''"
                                        :message="this.errors.is_4ps ? this.errors.is_4ps[0] : ''"
                                        expanded>
                                        <b-select v-model="fields.is_4ps" 
                                            placeholder="Beneficiary of 4Ps?" expanded>
                                            <option value="1">YES</option>
                                            <option value="0">NO</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column" v-if="fields.is_4ps == 1">
                                    <b-field label="If YES, Please input 4Ps Household Id No."
                                        :type="this.errors.household_4ps_id_no ? 'is-danger':''"
                                        :message="this.errors.household_4ps_id_no ? this.errors.household_4ps_id_no[0] : ''">
                                        <b-input type="text" v-model="fields.household_4ps_id_no" placeholder="4Ps Household Id No."></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <!-- Current Address -->

                            <div class="mb-2">
                                <h2><span>Current Address</span></h2>
                            </div>
                            
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Province" expanded
                                             :type="this.errors.current_province ? 'is-danger':''"
                                             :message="this.errors.current_province ? this.errors.current_province[0] : ''">
                                        <b-select v-model="fields.current_province" expanded placeholder="Province" @input="loadCurrentCity">
                                            <option v-for="(item, index) in current_provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="City/Municipality" expanded
                                             :type="this.errors.current_city ? 'is-danger':''"
                                             :message="this.errors.current_city ? this.errors.current_city[0] : ''">
                                        <b-select expanded v-model="fields.current_city" placeholder="City" @input="loadCurrentBarangay">
                                            <option v-for="(item, index) in current_cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Barangay" expanded
                                             :type="this.errors.current_barangay ? 'is-danger':''"
                                             :message="this.errors.current_barangay ? this.errors.current_barangay[0] : ''">
                                        <b-select v-model="fields.current_barangay" expanded placeholder="Barangay">
                                            <option v-for="(item, index) in current_barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="House #. Street">
                                        <b-input type="text" 
                                            v-model="fields.current_street" 
                                            placeholder="House #. Street"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Zip Code"
                                        :type="this.errors.current_zipcode ? 'is-danger':''"
                                        :message="this.errors.current_zipcode ? this.errors.current_zipcode[0] : ''">
                                        <b-input type="text" 
                                            v-model="fields.current_zipcode" 
                                            placeholder="Zip Code"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <!-- Permanent Address -->

                            <div class="mb-2">
                                <h2><span>Permanent Address</span></h2>
                            </div>
                            
                            <div class="buttons mt-5">
                                <b-button class="is-info is-small" @click="copyCurrentAddress" icon-left="home">Same as current address</b-button>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Province" expanded
                                             :type="this.errors.permanent_province ? 'is-danger':''"
                                             :message="this.errors.permanent_province ? this.errors.permanent_province[0] : ''">
                                        <b-select v-model="fields.permanent_province" expanded placeholder="Province" @input="loadPermanentCity">
                                            <option v-for="(item, index) in permanent_provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="City/Municipality" expanded
                                             :type="this.errors.permanent_city ? 'is-danger':''"
                                             :message="this.errors.permanent_city ? this.errors.permanent_city[0] : ''">
                                        <b-select expanded v-model="fields.permanent_city" placeholder="City" @input="loadPermanentBarangay">
                                            <option v-for="(item, index) in permanent_cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Barangay" expanded
                                            :type="this.errors.permanent_barangay ? 'is-danger':''"
                                            :message="this.errors.permanent_barangay ? this.errors.permanent_barangay[0] : ''">
                                        <b-select v-model="fields.permanent_barangay" expanded placeholder="Barangay">
                                            <option v-for="(item, index) in permanent_barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="House #. Street">
                                        <b-input type="text" v-model="fields.permanent_street" placeholder="House #. Street"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Zip Code"
                                        :type="this.errors.permanent_zipcode ? 'is-danger':''"
                                        :message="this.errors.permanent_zipcode ? this.errors.permanent_zipcode[0] : ''">
                                        <b-input type="text" v-model="fields.permanent_zipcode" 
                                            placeholder="Zip Code"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <!-- Parents/Guardians Information -->
                            <div class="divider">PARENTS/GUARDIANS INFORMATION</div>
                         
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Father Last Name"
                                             :type="this.errors.father_lname ? 'is-danger':''"
                                             :message="this.errors.father_lname ? this.errors.father_lname[0] : ''" >
                                        <b-input icon="account" placeholder="Father Last Name" v-model="fields.father_lname" type="text"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Father First Name"
                                             :type="this.errors.father_fname ? 'is-danger':''"
                                             :message="this.errors.father_fname ? this.errors.father_fname[0] : ''">
                                        <b-input icon="account" v-model="fields.father_fname" placeholder="Father First Name" type="text"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Father Middle Name">
                                        <b-input v-model="fields.father_mname" 
                                            icon="account" type="text" placeholder="Father Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Father Extension">
                                        <b-input v-model="fields.father_extension" 
                                            icon="account" type="text" placeholder="Father Extension"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Father Contact No."
                                        :type="this.errors.father_contact_no ? 'is-danger':''"
                                        :message="this.errors.father_contact_no ? this.errors.father_contact_no[0] : ''" >
                                        <b-input type="tel" 
                                            v-model="fields.father_contact_no" 
                                            icon="cellphone"
                                            pattern="^(09|\+639)\d{9}$"
                                            placeholder="Format: 09101112222"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <hr>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Mother Maiden Last Name"
                                             :type="this.errors.mother_maiden_lname ? 'is-danger':''"
                                             :message="this.errors.mother_maiden_lname ? this.errors.mother_maiden_lname[0] : ''" >
                                        <b-input icon="account" 
                                            placeholder="Mother Maiden Last Name"
                                            v-model="fields.mother_maiden_lname" type="text"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Mother Maiden First Name"
                                            :type="this.errors.mother_maiden_fname ? 'is-danger':''"
                                            :message="this.errors.mother_maiden_fname ? this.errors.mother_maiden_fname[0] : ''">
                                        <b-input icon="account" 
                                            v-model="fields.mother_maiden_fname" 
                                            placeholder="Mother Maiden First Name" type="text"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Mother Maiden Middle Name"
                                        :type="this.errors.mother_maiden_mname ? 'is-danger':''"
                                        :message="this.errors.mother_maiden_mname ? this.errors.mother_maiden_mname[0] : ''">
                                        <b-input v-model="fields.mother_maiden_mname" 
                                            type="text" 
                                            icon="account"
                                            placeholder="Mother Maiden Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Mother Maiden Contact No.">
                                        <b-input type="tel" v-model="fields.mother_maiden_contact_no" 
                                            pattern="^(09|\+639)\d{9}$"
                                            placeholder="Format: 09101112222"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <hr>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Guardian Last Name"
                                            :type="this.errors.guardian_lname ? 'is-danger':''"
                                            :message="this.errors.guardian_lname ? this.errors.guardian_lname[0] : ''" >
                                        <b-input icon="account" placeholder="Guardian Last Name" v-model="fields.guardian_lname" type="text"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Guardian First Name"
                                            :type="this.errors.guardian_fname ? 'is-danger':''"
                                            :message="this.errors.guardian_fname ? this.errors.guardian_fname[0] : ''">
                                        <b-input icon="account" v-model="fields.guardian_fname" placeholder="Guardian First Name" type="text"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Guardian Middle Name">
                                        <b-input v-model="fields.guardian_mname" 
                                            icon="account"
                                            type="text" placeholder="Guardian Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Guardian Extension">
                                        <b-input v-model="fields.guardian_extension" 
                                            icon="account" type="text" placeholder="Guardian Extension"></b-input>
                                    </b-field>
                                </div>

                                

                                <div class="column">
                                    <b-field label="Guardian Contact No."
                                        :type="this.errors.guardian_contact_no ? 'is-danger':''"
                                        :message="this.errors.guardian_contact_no ? this.errors.guardian_contact_no[0] : ''">
                                        <b-input type="text" v-model="fields.guardian_contact_no" 
                                            icon="cellphone" 
                                            required
                                            placeholder="Guardian Contact No."></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="divider">RETURNING LEARNER (BALIK-ARAL) / TRANSFER / MOVE IN</div>
                  
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Grade Level Completed"
                                        :type="this.errors.last_grade_level_completed ? 'is-danger':''"
                                        :message="this.errors.last_grade_level_completed ? this.errors.last_grade_level_completed[0] : ''">
                                        <b-input v-model="fields.last_grade_level_completed" 
                                            icon="account"
                                            type="text" placeholder="Last Grade Level Completed"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Last School Year Completed"
                                        :type="this.errors.last_school_year_completed ? 'is-danger':''"
                                        :message="this.errors.last_school_year_completed ? this.errors.last_school_year_completed[0] : ''">
                                        <b-input v-model="fields.last_school_year_completed" 
                                            icon="calendar"
                                            type="text" placeholder="Last School Year Completed"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last School Attended"
                                        :type="this.errors.last_school_attended ? 'is-danger':''"
                                        :message="this.errors.last_school_attended ? this.errors.last_school_attended[0] : ''">
                                        <b-input v-model="fields.last_school_attended" 
                                            icon="account"
                                            type="text" placeholder="Last School Attended"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="School Id"
                                        :type="this.errors.last_schoold_id ? 'is-danger':''"
                                        :message="this.errors.last_schoold_id ? this.errors.last_schoold_id[0] : ''">
                                        <b-input v-model="fields.last_schoold_id" 
                                            icon="account"
                                            type="text" placeholder="School Id"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="divider">FOR LEARNERS IN SENIOR HIGH SCHOOL</div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Semester" expanded
                                        :type="this.errors.semester_id ? 'is-danger':''"
                                        :message="this.errors.semester_id ? this.errors.semester_id[0] : ''">
                                        <b-select v-model="fields.semester_id" expanded
                                            icon="account"
                                            placeholder="Semester">
                                            <option :value="item.semester_id" v-for="(item, ix) in semesters" :key="ix">
                                                {{  item.semester }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="School Id"
                                        :type="this.errors.senior_high_school_id ? 'is-danger':''"
                                        :message="this.errors.senior_high_school_id ? this.errors.senior_high_school_id[0] : ''">
                                        <b-input v-model="fields.senior_high_school_id" 
                                            icon="account"
                                            type="text" placeholder="School Id"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Track"
                                        :type="this.errors.track_id ? 'is-danger':''"
                                        :message="this.errors.track_id ? this.errors.track_id[0] : ''">
                                        <b-select v-model="fields.track_id" expanded
                                            icon="account"
                                            placeholder="Track"
                                            @input="loadStrands">
                                            <option :value="item.track_id" v-for="(item, ix) in tracks" :key="`track${ix}`">
                                                {{  item.track }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Strand"
                                        :type="this.errors.strand_id ? 'is-danger':''"
                                        :message="this.errors.strand_id ? this.errors.strand_id[0] : ''">
                                        <b-select v-model="fields.strand_id" expanded
                                            icon="account"
                                            placeholder="Strand">
                                            <option :value="item.strand_id" v-for="(item, ix) in strands" :key="`strand${ix}`">
                                                {{  item.strand }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <hr>
                            <div class="buttons is-right">
<!--                                <b-button class="button is-info is-outlined"-->
<!--                                    @click="debug">DEBUG</b-button>-->
                                <button :class="btnClass">Register</button>
                            </div>

                        </div> <!--panel -body-->
                    </div> <!--panel-->

                </form>
            </div><!--column-->
        </div><!--cols-->
    </section>
</template>

<script>
export default {

    props: ['propData', 'propDataId'],

    data(){
        return{

            id: 0,

            fields: {

                lrn: '',
                lname: '',
                fname: '',
                mname: '',
                sex:'',
                age: null,
                birthdate: null,
                birthplace: '',

                is_indigenous: null,
                if_yes_indigenous: null,
                is_4ps: null,
                household_4ps_id_no: null,

                permanent_province: '',
                permanent_city: '',
                permanent_barangay: '',
                permanent_street: '',
                permanent_zipcode: '',

                current_province: '',
                current_city: '',
                current_barangay: '',
                current_street: '',
                current_zipcode: '',

                semester: null,
                track_id: null,
                strand_id: null,

            },

            errors: {},

            gradeLevels: [],
            current_provinces: [],
            current_cities: [],
            current_barangays: [],

            permanent_provinces: [],
            permanent_cities: [],
            permanent_barangays: [],

            semesters: [],
            tracks: [],
            strands: [],

            btnClass: {
                'is-loading': false,
                'button': true,
                'is-primary': true
            }
        }
    },
    methods: {
        //ADDRESS
        loadCurrentProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.current_provinces = res.data;
            })
        },
        loadCurrentCity: function(){
            axios.get('/load-cities?prov=' + this.fields.current_province).then(res=>{
                this.current_cities = res.data;
            })
        },

        loadCurrentBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.current_province + '&city_code='+this.fields.current_city).then(res=>{
                this.current_barangays = res.data;
            })
        },

        loadPermanentProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.permanent_provinces = res.data;
            })
        },
        loadPermanentCity: function(){
            axios.get('/load-cities?prov=' + this.fields.permanent_province).then(res=>{
                this.permanent_cities = res.data;
            })
        },

        loadPermanentBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.permanent_province + '&city_code='+this.fields.permanent_city).then(res=>{
                this.permanent_barangays = res.data;
            })
        },
        //ADDRESS

        loadSemesters(){
            axios.get('/load-semesters').then(res=>{
                this.semesters = res.data;
            })
        },
        loadTracks(){
            axios.get('/load-tracks').then(res=>{
                this.tracks = res.data;
            })
        },
        loadStrands(){
            axios.get('/load-strands?trackid=' +  this.fields.track_id).then(res=>{
                this.strands = res.data;
            })
        },
        loadGradeLevels(){
            axios.get('/load-grade-levels').then(res=>{
                this.gradeLevels = res.data;
            })
        },

        //copy current address
        copyCurrentAddress(){
            this.fields.permanent_province = this.fields.current_province;

            this.loadPermanentCity();

            this.fields.permanent_city = this.fields.current_city;

            this.loadPermanentBarangay();

            this.fields.permanent_barangay = this.fields.current_barangay;


            this.fields.permanent_street = this.fields.current_street;
            this.fields.permanent_zipcode = this.fields.current_zipcode;
        },


        submit(){
            this.btnClass['is-loading'] = true
            this.errors = {}; //clear all errors, to refresh errors

            if(this.id > 0){
                /* update */
                axios.put('/manage-learners/' + this.id, this.fields).then(res=>{
                    this.btnClass['is-loading'] = false

                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: "UPDATED!",
                            message: 'Data successfully updated.',
                            type: 'is-success',
                            onConfirm: ()=>  window.location = '/manage-learners'
                        });
                    }
                }).catch(err=>{
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                        this.$buefy.dialog.alert({
                            title: 'Error!',
                            hasIcon: true,
                            message: 'Some fields are required. Please check fields marked red.',
                            type: 'is-danger',
                        })
                    }else{
                        alert('An error occured.');
                    }
                });
            }else{
                /* insert */
                this.btnClass['is-loading'] = false

                axios.post('/manage-learners', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: "SAVED!",
                            message: 'Data successfully saved.',
                            type: 'is-success',
                            onConfirm: ()=>  window.location = '/manage-learners'
                        });
                    }
                }).catch(err=>{
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                        this.$buefy.dialog.alert({
                            title: 'Error!',
                            hasIcon: true,
                            message: 'Some fields are required. Please check fields marked red.',
                            type: 'is-danger',
                        })
                    }else{
                        alert('An error occured.');
                    }
                });
            }
            
        },

        initData(){
           

            this.loadCurrentProvince();
            this.loadPermanentProvince();

            this.loadSemesters()
            this.loadTracks()
            this.loadGradeLevels()

            if(this.propDataId > 0){
                this.setData();
            }
            
        },

        setData(){
            this.btnClass['is-loading'] = true

            let data = JSON.parse(this.propData)
            this.id = data.learner_id

            console.log(data)

            this.fields.grade_level = data.grade_level
            this.fields.is_returnee = data.is_returnee
            this.fields.psa = data.psa
            this.fields.lrn = data.lrn
            this.fields.lname = data.lname
            this.fields.fname = data.fname
            this.fields.mname = data.mname
            this.fields.extension = data.extension
            this.fields.sex = data.sex
            this.fields.birthdate = new Date(data.birthdate)
            this.fields.birthplace = data.birthplace
            this.fields.age = data.age
            this.fields.mother_tongue = data.mother_tongue
            this.fields.is_indigenous = data.is_indigenous
            this.fields.if_yes_indigenous = data.if_yes_indigenous
            this.fields.is_4ps = data.is_4ps
            this.fields.household_4ps_id_no = data.household_4ps_id_no


            this.fields.current_province = data.current_province ? data.current_province.provCode : null
            this.loadCurrentCity()
            this.fields.current_city = data.current_city ? data.current_city.citymunCode : null
            this.loadCurrentBarangay()
            this.fields.current_barangay = data.current_barangay ? data.current_barangay.brgyCode : null
            this.fields.current_street = data.current_street
            this.fields.current_zipcode = data.current_zipcode

            this.fields.permanent_province = data.permanent_province ? data.permanent_province.provCode : null
            this.loadPermanentCity()
            this.fields.permanent_city = data.permanent_city ? data.permanent_city.citymunCode : null
            this.loadPermanentBarangay()
            this.fields.permanent_barangay = data.permanent_barangay ? data.permanent_barangay.brgyCode : null
            this.fields.permanent_street = data.permanent_street
            this.fields.permanent_zipcode = data.permanent_zipcode

            this.fields.father_lname = data.father_lname
            this.fields.father_fname = data.father_fname
            this.fields.father_mname = data.father_mname
            this.fields.father_contact_no = data.father_contact_no
            this.fields.father_extension = data.father_extension

            this.fields.mother_maiden_lname = data.mother_maiden_lname
            this.fields.mother_maiden_fname = data.mother_maiden_fname
            this.fields.mother_maiden_mname = data.mother_maiden_mname
            this.fields.mother_maiden_contact_no = data.mother_maiden_contact_no

            this.fields.guardian_lname = data.guardian_lname
            this.fields.guardian_fname = data.guardian_fname
            this.fields.guardian_mname = data.guardian_mname
            this.fields.guardian_contact_no = data.guardian_contact_no

            this.fields.last_grade_level_completed = data.last_grade_level_completed
            this.fields.last_school_year_completed = data.last_school_year_completed
            this.fields.last_school_attended = data.last_school_attended
            this.fields.last_schoold_id = data.last_schoold_id

            this.fields.semester_id = data.semester_id
            this.fields.senior_high_school_id = data.senior_high_school_id

            this.fields.track_id = data.track_id
            this.fields.strand_id = data.strand_id
            this.btnClass['is-loading'] = false

        },

        debug(){

            this.fields.grade_level = 12
            this.fields.is_returnee = 1
            this.fields.psa = 'PSACERT-12231'
            this.fields.lrn = '20221123231'
            this.fields.lname = 'Abapo'
            this.fields.fname = 'Wayne'
            this.fields.mname = 'Yes'
            this.fields.extension = ''
            this.fields.sex = 'MALE'
            this.fields.birthdate = new Date('1988-08-08')
            this.fields.birthplace = 'Baroy Lanao del Norte'
            this.fields.age = '17'
            this.fields.mother_tongue = 'Cebuano'
            this.fields.is_indigenous = 1
            this.fields.if_yes_indigenous = 'IGOROT'
            this.fields.is_4ps = 1
            this.fields.household_4ps_id_no = '4PS-11234'

            this.fields.current_street = 'Juan Luna St.'
            this.fields.current_zipcode = '9210'

            this.fields.father_lname = 'FATHERLNAME'
            this.fields.father_fname = 'FATHERFNAME'
            this.fields.father_mname = 'FATHERMNAME'
            this.fields.father_contact_no = '09161234567'

            this.fields.mother_maiden_lname = 'MAIDENLAST'
            this.fields.mother_maiden_fname = 'MAIDENFIRST'
            this.fields.mother_maiden_mname = 'MAIDENTEST'
            this.fields.mother_maiden_contact_no = '09161234567'

            this.fields.guardian_lname = 'GLASTNAME'
            this.fields.guardian_fname = 'GFNAME'
            this.fields.guardian_mname = 'GMNAME'
            this.fields.guardian_contact_no = '09161234567'

            this.fields.last_grade_level_completed = 'GRADE 11'
            this.fields.last_school_year_completed = '2021-2022'

            this.fields.last_school_attended = 'LNNCHS'
            this.fields.last_schoold_id = '2022-2211'

            this.fields.semester_id = 1
            this.fields.senior_high_school_id = '200222'

            this.fields.track_id = 1
            this.fields.strand_id = 1

        }
    },


    mounted() {

        this.initData();


    }
}
</script>

<style scoped>


    .box-title{
        font-weight: bold;
        font-size: 1.5rem;
        text-align: center;
    }

/*    dere lang kubia ang panel color*/
</style>
