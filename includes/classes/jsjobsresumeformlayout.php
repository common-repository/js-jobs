<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSJobsResumeFormlayout {

    function __construct(){
        $fieldsordering = JSJOBSincluder::getJSModel('fieldordering')->getFieldsOrderingforForm(3); // resume fields
        jsjobs::$_data[2] = array();
        foreach ($fieldsordering AS $field) {
            jsjobs::$_data['fieldtitles'][$field->field] = $field->fieldtitle;
            jsjobs::$_data[2][$field->section][$field->field] = $field->required;
        }
    }

    function getFieldTitleByField($field){
        return __(jsjobs::$_data['fieldtitles'][$field],'js-jobs');
    }

    function printResume() {
        //check wheather to show resume form or resumeformview
        $resumeformview = 1;
        if (isset(jsjobs::$_data['resumeid']) && is_numeric(jsjobs::$_data['resumeid'])) {
            $resumeformview = 0;
        }

        $html = '<div id="resume-wrapper">';
        if (!isset(jsjobs::$_data[0]['personal_section']->uid)) {
            $isowner = 1; // user come to add new resume
        } else {
            $isowner = (JSJOBSincluder::getObjectClass('jsjobsuser')->uid() == jsjobs::$_data[0]['personal_section']->uid) ? 1 : 0;
        }
        if ($resumeformview == 0) {
            $html .= $this->getPersonalTopSection($isowner, $resumeformview);
        }
        $html .= '<div class="resume-section-title personal"><img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/personal-info.png" />' . __('Personal information', 'js-jobs') . '</div>';
        $html .= $this->getPersonalSection($resumeformview);
        $config_array_sec = JSJOBSincluder::getJSModel('configuration')->getConfigByFor('resume');
        if (isset(jsjobs::$_data[2][2]['section_address'])) {
            $html .= '<div class="resume-section-title"><img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/word.png" />' . __('Addresses', 'js-jobs') . '</div>';
            $html .= $this->getAddressesSection($resumeformview, 0);
            $count = isset(jsjobs::$_data[0]['address_section']) ? COUNT(jsjobs::$_data[0]['address_section']) : 0;
            if ($config_array_sec['max_resume_addresses'] > $count) {
                $html .= '<a class="add" data-section="addresses">' . ' + ' . __('Add New','js-jobs') .' '. __('Address', 'js-jobs') . '</a>';
            }
        }
        if (isset(jsjobs::$_data[2][3]['section_education'])) {
            $html .= '<div class="resume-section-title"><img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/education.png" />' . __('Education', 'js-jobs') . '</div>';
            $html .= $this->getEducationSection($resumeformview, 0);
            $count = isset(jsjobs::$_data[0]['institute_section']) ? COUNT(jsjobs::$_data[0]['institute_section']) : 0;
            if ($config_array_sec['max_resume_institutes'] > $count) {
                $html .= '<a class="add" data-section="institutes">' . ' + ' . __('Add New','js-jobs') .' '. __('Education', 'js-jobs') . '</a>';
            }
        }
        if (isset(jsjobs::$_data[2][4]['section_employer'])) {
            $html .= '<div class="resume-section-title"><img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/employer.png" />' . __('Employer', 'js-jobs') . '</div>';
            $html .= $this->getEmployerSection($resumeformview, 0);
            $count = isset(jsjobs::$_data[0]['employer_section']) ? COUNT(jsjobs::$_data[0]['employer_section']) : 0;
            if ($config_array_sec['max_resume_employers'] > $count) {
                $html .= '<a class="add" data-section="employers">' . ' + ' . __('Add New','js-jobs') .' '. __('Employer', 'js-jobs') . '</a>';
            }
        }
        if (isset(jsjobs::$_data[2][5]['section_skills'])) {
            $html .= '<div class="resume-section-title">
                        <img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/skills.png" />' . __('Skills', 'js-jobs') . '
                        <a class="skilledit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>
                    </div>';

            $html .= $this->getSkillSection($resumeformview, 0);
        }
        if (isset(jsjobs::$_data[2][6]['section_resume'])) {
            $html .= '<div class="resume-section-title">
                        <img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/resume.png" />' . __('Resume', 'js-jobs') . '
                        <a class="resumeedit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>
                    </div>';
            $html .= $this->getResumeSection($resumeformview, 0);
        }
        if (isset(jsjobs::$_data[2][7]['section_reference'])) {
            $html .= '<div class="resume-section-title"><img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/referances.png" />' . __('References', 'js-jobs') . '</div>';
            $html .= $this->getReferenceSection($resumeformview, 0);
            $count = isset(jsjobs::$_data[0]['reference_section']) ? COUNT(jsjobs::$_data[0]['reference_section']) : 0;
            if ($config_array_sec['max_resume_references'] > $count) {
                $html .= '<a class="add" data-section="references">' . ' + ' . __('Add New','js-jobs') .' '. __('Reference', 'js-jobs') . '</a>';
            }
        }
        if (isset(jsjobs::$_data[2][8]['section_language'])) {
            $html .= '<div class="resume-section-title"><img class="heading-img" src="' . jsjobs::$_pluginpath . 'includes/images/language.png" />' . __('Languages', 'js-jobs') . '</div>';
            $html .= $this->getLanguageSection($resumeformview, 0);
            $count = isset(jsjobs::$_data[0]['language_section']) ? COUNT(jsjobs::$_data[0]['language_section']) : 0;
            if ($config_array_sec['max_resume_languages'] > $count) {
                $html .= '<a class="add" data-section="languages">' . ' + ' . __('Add New','js-jobs') .' '. __('Language', 'js-jobs') . '</a>';
            }
        }
        $html .= '</div>';
        echo $html;
    }

    function getPersonalTopSection($owner, $resumeformview) {
        $html = '<div class="resume-top-section">';
        if (isset(jsjobs::$_data[2][1]['photo'])) {
            $html .= '<div class="js-col-lg-4">';
            if (jsjobs::$_data[0]['personal_section']->photo != '') {
                $data_directory = JSJOBSincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                $img = jsjobs::$_pluginpath . $data_directory . '/data/jobseeker/resume_' . jsjobs::$_data[0]['personal_section']->id . '/photo/' . jsjobs::$_data[0]['personal_section']->photo;
            } else {
                $img = jsjobs::$_pluginpath . 'includes/images/users.png';
            }
            $html .= '<img src="' . $img . '" />';
            $html .= '</div>';
            $html .= '<div class="js-col-lg-8">';
        } else {
            $html .= '<div class="js-col-lg-12">';
        }
        if (isset(jsjobs::$_data[2][1]['first_name']) || isset(jsjobs::$_data[2][1]['middle_name']) || isset(jsjobs::$_data[2][1]['last_name'])) {
            $html .= '<span class="resume-tp-name">' . jsjobs::$_data[0]['personal_section']->first_name . ' ' . jsjobs::$_data[0]['personal_section']->middle_name . ' ' . jsjobs::$_data[0]['personal_section']->last_name;
            $layout = JSJOBSrequest::getVar('layout');
            $editsocialclass = '';
            if ($resumeformview == 0 && ($layout == 'addresume' || $owner == 1)) {
                $html .= '<a class="personal_section_edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                $editsocialclass = 'editform';
            }elseif(current_user_can('manage_options') || (!is_user_logged_in() && isset($_SESSION['wp-jsjobs']))) {
                $html .= '<a class="personal_section_edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                $editsocialclass = 'editform';
            }
            $html .= '<div id="job-info-sociallink" class="' . $editsocialclass . '">';
            if (!empty(jsjobs::$_data[0]['personal_section']->facebook)) {
                $html .= '<a href="' . jsjobs::$_data[0]['personal_section']->facebook . '" target="_blank"><img src="' . jsjobs::$_pluginpath . 'includes/images/scround/fb.png"/></a>';
            }
            if (!empty(jsjobs::$_data[0]['personal_section']->twitter)) {
                $html .= '<a href="' . jsjobs::$_data[0]['personal_section']->twitter . '" target="_blank"><img src="' . jsjobs::$_pluginpath . 'includes/images/scround/twitter.png"/></a>';
            }
            if (!empty(jsjobs::$_data[0]['personal_section']->googleplus)) {
                $html .= '<a href="' . jsjobs::$_data[0]['personal_section']->googleplus . '" target="_blank"><img src="' . jsjobs::$_pluginpath . 'includes/images/scround/gmail.png"/></a>';
            }
            if (!empty(jsjobs::$_data[0]['personal_section']->linkedin)) {
                $html .= '<a href="' . jsjobs::$_data[0]['personal_section']->linkedin . '" target="_blank"><img src="' . jsjobs::$_pluginpath . 'includes/images/scround/in.png"/></a>';
            }
            $html .= '</div>';

            $html .= '</span>';
        }
        if (isset(jsjobs::$_data[2][1]['application_title'])) {
            $html .= '<span class="resume-tp-apptitle">' . jsjobs::$_data[0]['personal_section']->application_title . '</span>';
        }
        if (jsjobs::$_data['resumecontactdetail'] == true) {
            if (isset(jsjobs::$_data[2][1]['email_address'])) {
                $html .= '<span class="resume-tp-apptitle">' . jsjobs::$_data[0]['personal_section']->email_address . '</span>';
            }
        }
        $layout = JSJOBSrequest::getVar('jsjobslt');
        if ($layout != 'printresume') {
            if ($owner != 1) { // Current user is not owner and (Consider as employer)
                if (isset(jsjobs::$_data['coverletter']) && !empty(jsjobs::$_data['coverletter'])) {
                    // View cover letter icon 
                    $html .= '<a href="#" onclick="showPopupAndSetValues();"><img src="' . jsjobs::$_pluginpath . 'includes/images/resume/coverletter.png"/></a>';
                }
            }
            $html .= '<a target="_blank" href="' . site_url("?page_id=" . jsjobs::getPageid() . "&jsjobsme=resume&jsjobslt=pdf&jsjobsid=" . jsjobs::$_data[0]['personal_section']->id) . '"><img src="' . jsjobs::$_pluginpath . '/includes/images/pdf.png" /></a>';
            $html .= '<a target="_blank" href="' . site_url('?page_id=' . jsjobs::getPageid() . '&jsjobsme=export&task=exportresume&action=jstask&jsjobsid=' . jsjobs::$_data[0]['personal_section']->id) . '"><img src="' . jsjobs::$_pluginpath . '/includes/images/export.png" /></a>';
            $html .= '<a href="#" id="print-link" data-resumeid="' . jsjobs::$_data[0]['personal_section']->id . '" ><img src="' . jsjobs::$_pluginpath . '/includes/images/print.png" /></a>';
            if(!empty(jsjobs::$_data[0]['file_section'])){
                $html .= '<a class="downloadall" target="_blank" href="' . site_url('?page_id=' . jsjobs::getPageid() . '&jsjobsme=resume&action=jstask&task=getallresumefiles&resumeid=' . jsjobs::$_data[0]['personal_section']->id) . '" ><img src="' . jsjobs::$_pluginpath . '/includes/images/download-all.png" />' . __('Resume files download', 'js-jobs') . '</a>';
            }
        } elseif ($layout == 'printresume') {
            $html .= '<a href="javascript:window.print();" class="grayBtn">' . __('Print', 'js-jobs') . '</a>';
        }

        $html .= '</div>'; // close for the inner section
        $html .= '</div>'; // closing div of resume-top-section
        return $html;
    }

    function getPersonalSection($resumeformview, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            $html .= '<div class="section_wrapper" data-section="personal" data-sectionid="">';
            $i = 0;
            foreach (jsjobs::$_data[2][1] AS $field => $required) {
                switch ($field) {
                    case 'cell':
                        if (jsjobs::$_data['resumecontactdetail'] == true) {
                            $text = $this->getFieldTitleByField($field);
                            $value = jsjobs::$_data[0]['personal_section']->cell;
                            $html .= $this->getRowForView($text, $value, $i);
                        }
                        break;
                    case 'nationality':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->nationality;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'gender':
                        $text = $this->getFieldTitleByField($field);
                        $value = '';
                        switch (jsjobs::$_data[0]['personal_section']->gender) {
                            case '0':$value = __('Does not matter', 'js-jobs');
                                break;
                            case '1':$value = __('Male', 'js-jobs');
                                break;
                            case '2':$value = __('Female', 'js-jobs');
                                break;
                        }
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'job_category':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->categorytitle;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'jobtype':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->jobtypetitle;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'heighestfinisheducation':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->highestfinisheducation;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'total_experience':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->total_experience;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'home_phone':
                        if (jsjobs::$_data['resumecontactdetail'] == true) {
                            $text = $this->getFieldTitleByField($field);
                            $value = jsjobs::$_data[0]['personal_section']->home_phone;
                            $html .= $this->getRowForView($text, $value, $i);
                        }
                        break;
                    case 'work_phone':
                        if (jsjobs::$_data['resumecontactdetail'] == true) {
                            $text = $this->getFieldTitleByField($field);
                            $value = jsjobs::$_data[0]['personal_section']->work_phone;
                            $html .= $this->getRowForView($text, $value, $i);
                        }
                        break;
                    case 'date_of_birth':
                        $text = $this->getFieldTitleByField($field);
                        $dateformat = jsjobs::$_configuration['date_format'];
						if(jsjobs::$_data[0]['personal_section']->date_of_birth != '0000-00-00 00:00:00' && jsjobs::$_data[0]['personal_section']->date_of_birth != ''){
							$value = date_i18n($dateformat, strtotime(jsjobs::$_data[0]['personal_section']->date_of_birth));							
						}else{
							$value = '';
						}
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'date_start':
                        $text = $this->getFieldTitleByField($field);
                        $dateformat = jsjobs::$_configuration['date_format'];
						if(jsjobs::$_data[0]['personal_section']->date_start != '0000-00-00 00:00:00' && jsjobs::$_data[0]['personal_section']->date_start != ''){
							$value = date_i18n($dateformat, strtotime(jsjobs::$_data[0]['personal_section']->date_start));							
						}else{
							$value = '';
						}
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'salary':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->salary;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'desired_salary':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->dsalary;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'video':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->video;
                        $vtype = jsjobs::$_data[0]['personal_section']->videotype;
                        $html .= $this->getRowForVideoView($text, $value, $vtype);
                        $i = 0;
                        break;
                    case 'keywords':
                        $text = $this->getFieldTitleByField($field);
                        $value = jsjobs::$_data[0]['personal_section']->keywords;
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'searchable':
                        $text = $this->getFieldTitleByField($field);
                        $value = (jsjobs::$_data[0]['personal_section']->searchable == 1) ? __('Yes', 'js-jobs') : __('No', 'js-jobs');
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'driving_license':
                        $text = $this->getFieldTitleByField($field);
                        $value = (jsjobs::$_data[0]['personal_section']->driving_license == 1) ? __('Yes', 'js-jobs') : __('No', 'js-jobs');
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'license_no':
                        $text = $this->getFieldTitleByField($field);
                        $value = (jsjobs::$_data[0]['personal_section']->driving_license == 1) ? jsjobs::$_data[0]['personal_section']->license_no : __('N/A', 'js-jobs');
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'license_country':
                        $text = $this->getFieldTitleByField($field);
                        $value = (jsjobs::$_data[0]['personal_section']->driving_license == 1) ? jsjobs::$_data[0]['personal_section']->licensecountryname : __('N/A', 'js-jobs');
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'iamavailable':
                        $text = $this->getFieldTitleByField($field);
                        $value = (jsjobs::$_data[0]['personal_section']->iamavailable == 1) ? __('Yes', 'js-jobs') : __('No', 'js-jobs');
                        $html .= $this->getRowForView($text, $value, $i);
                        break;
                    case 'resumefiles':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        $text = $this->getFieldTitleByField($field);
                        $html .= $this->getAttachmentRowForView($text);
                        $i = 0;
                        break;
                    default:
                        $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, jsjobs::$_data[0]['personal_section']->params); // 11 view resume
                        if (is_array($array))
                            $html .= $this->getRowForView($array['title'], $array['value'], $i);
                        break;
                }
            }
            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                $html .= '</div>'; // closing div for the more option
            }
            $html .= '</div>'; //section wrapper end;
        } else { // new form
            $html .= '<div class="section_wrapper form" data-section="personal" data-sectionid="">';
            $imgtxt = isset(jsjobs::$_data[0]['personal_section']->application_title) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Personal Information', 'js-jobs') . '</div>';
            $html .= '<form>';
            $k = 0;
            $rname = 0;
            $cellphone = 0;
            foreach (jsjobs::$_data[2][1] AS $field => $required) {
                switch ($field) {
                    case 'application_title':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->application_title) ? jsjobs::$_data[0]['personal_section']->application_title : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('application_title', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'first_name':
                    case 'middle_name':
                    case 'last_name':
                        if ($rname == 0) { // just b/c of ordering maintain further in fields
                            $text = $this->getFieldTitleByField($field);
                            $namefield = '';
                            $reqappend = 0;
                            foreach (jsjobs::$_data[2][1] AS $field => $required) {
                                switch ($field) {
                                    case 'first_name':
                                        $value = isset(jsjobs::$_data[0]['personal_section']->first_name) ? jsjobs::$_data[0]['personal_section']->first_name : '';
                                        $req = ''; // for checking field is required or not
                                        if ($required == 1) {
                                            if ($reqappend == 0) {
                                                $text .= '<span style="color:red;">*</span>';
                                                $reqappend++;
                                            }
                                            $req = 'required';
                                        }
                                        $namefield .= JSJOBSformfield::text('first_name', $value, array('class' => 'inputbox threefields', 'data-validation' => $req));
                                        break;
                                    case 'middle_name':
                                        $value = isset(jsjobs::$_data[0]['personal_section']->middle_name) ? jsjobs::$_data[0]['personal_section']->middle_name : '';
                                        $req = ''; // for checking field is required or not
                                        if ($required == 1) {
                                            if ($reqappend == 0) {
                                                $text .= '<span style="color:red;">*</span>';
                                                $reqappend++;
                                            }
                                            $req = 'required';
                                        }
                                        $namefield .= JSJOBSformfield::text('middle_name', $value, array('class' => 'inputbox threefields', 'data-validation' => $req));
                                        break;
                                    case 'last_name':
                                        $value = isset(jsjobs::$_data[0]['personal_section']->last_name) ? jsjobs::$_data[0]['personal_section']->last_name : '';
                                        $req = ''; // for checking field is required or not
                                        if ($required == 1) {
                                            if ($reqappend == 0) {
                                                $text .= '<span style="color:red;">*</span>';
                                                $reqappend++;
                                            }
                                            $req = 'required';
                                        }
                                        $namefield .= JSJOBSformfield::text('last_name', $value, array('class' => 'inputbox threefields', 'data-validation' => $req));
                                        break;
                                }
                            }
                            $html .= $this->getRowForForm($text, $namefield);
                            $rname++;
                        }
                        break;
                    case 'cell':
                    case 'home_phone':
                    case 'work_phone':
                        if ($cellphone == 0) { // just b/c of ordering maintain further in fields
                            $text = $this->getFieldTitleByField($field);
                            $namefield = '';
                            $reqappend = 0;
                            foreach (jsjobs::$_data[2][1] AS $field => $required) {
                                switch ($field) {
                                    case 'cell':
                                        $value = isset(jsjobs::$_data[0]['personal_section']->cell) ? jsjobs::$_data[0]['personal_section']->cell : '';
                                        $req = ''; // for checking field is required or not
                                        if ($required == 1) {
                                            if ($reqappend == 0) {
                                                $text .= '<span style="color:red;">*</span>';
                                                $reqappend++;
                                            }
                                            $req = 'required';
                                        }
                                        $namefield .= JSJOBSformfield::text('cell', $value, array('class' => 'inputbox threefields', 'data-validation' => $req));
                                        break;
                                    case 'home_phone':
                                        $value = isset(jsjobs::$_data[0]['personal_section']->home_phone) ? jsjobs::$_data[0]['personal_section']->home_phone : '';
                                        $req = ''; // for checking field is required or not
                                        if ($required == 1) {
                                            if ($reqappend == 0) {
                                                $text .= '<span style="color:red;">*</span>';
                                                $reqappend++;
                                            }
                                            $req = 'required';
                                        }
                                        $namefield .= JSJOBSformfield::text('home_phone', $value, array('class' => 'inputbox threefields', 'data-validation' => $req));
                                        break;
                                    case 'work_phone':
                                        $value = isset(jsjobs::$_data[0]['personal_section']->work_phone) ? jsjobs::$_data[0]['personal_section']->work_phone : '';
                                        $req = ''; // for checking field is required or not
                                        if ($required == 1) {
                                            if ($reqappend == 0) {
                                                $text .= '<span style="color:red;">*</span>';
                                                $reqappend++;
                                            }
                                            $req = 'required';
                                        }
                                        $namefield .= JSJOBSformfield::text('work_phone', $value, array('class' => 'inputbox threefields', 'data-validation' => $req));
                                        break;
                                }
                            }
                            $html .= $this->getRowForForm($text, $namefield);
                            $cellphone++;
                        }
                        break;
                    case 'email_address':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->email_address) ? jsjobs::$_data[0]['personal_section']->email_address : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('email_address', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'nationality':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->nationalityid) ? jsjobs::$_data[0]['personal_section']->nationalityid : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('nationality', JSJOBSincluder::getJSModel('country')->getCountriesForCombo(), $value, __('Select','js-jobs') .'&nbsp;'. __('Nationality', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'driving_license':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->driving_license) ? jsjobs::$_data[0]['personal_section']->driving_license : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('driving_license', JSJOBSincluder::getJSModel('common')->getYesNo(), $value, __('Driving License', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'license_no':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->license_no) ? jsjobs::$_data[0]['personal_section']->license_no : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('license_no', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'license_country':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->license_country) ? jsjobs::$_data[0]['personal_section']->license_country : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('license_country', JSJOBSincluder::getJSModel('country')->getCountriesForCombo(), $value, __('Select','js-jobs') .'&nbsp;'. __('License Country', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'photo':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->photo) ? jsjobs::$_data[0]['personal_section']->photo : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        if (isset(jsjobs::$_data[0]['personal_section']->photo) && jsjobs::$_data[0]['personal_section']->photo != '') {
                            $data_directory = JSJOBSincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                            $img = jsjobs::$_pluginpath . $data_directory . '/data/jobseeker/resume_' . jsjobs::$_data[0]['personal_section']->id . '/photo/' . jsjobs::$_data[0]['personal_section']->photo;
                        } else {
                            $img = jsjobs::$_pluginpath . 'includes/images/users.png';
                        }
                        $field = '<input style="display:none" type="file" name="photo" class="photo" id="photo" />
                        <img class="rs_photo" id="rs_photo" src="' . $img . '"/><br>';
                            $logoformat = JSJOBSincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                            $maxsize = JSJOBSincluder::getJSModel('configuration')->getConfigurationByConfigName('resume_photofilesize');
                            $p_detail = '('.$logoformat.')<br>';
                            $p_detail .= '('.__("Max logo size allowed","js-jobs").' '.$maxsize.' Kb)';
                        
                        $field .= $p_detail;
                        
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'gender':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->gender) ? jsjobs::$_data[0]['personal_section']->gender : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('gender', JSJOBSincluder::getJSModel('common')->getGender(), $value, __('Select','js-jobs') .'&nbsp;'. __('Gender', 'js-jobs'), array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'resumefiles':
                        $text = $this->getFieldTitleByField($field);
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = '<input style="display:none;" type="file" id="resumefiles" name="resumefiles[]" data-validation="' . $req . '" multiple="true" />
                                    <div id="resumefileswrapper"><span class="livefiles" style="display:inline-block;float:left;"></span>';
                        if (!empty(jsjobs::$_data[0]['file_section'])) {
                            foreach (jsjobs::$_data[0]['file_section'] AS $file) {
                                $field .= '<a href="#" id="file_' . $file->id . '" onclick="deleteResumeFile(' . $file->id . ');" class="file">
                                            <span class="filename">' . $file->filename . '</span><span class="fileext"></span>
                                            <img class="filedownload" src="' . jsjobs::$_pluginpath . 'includes/images/resume/cancel.png" />
                                        </a>';
                            }
                        }
                        $field .= '<span class="resume-selectfiles"><img src="' . jsjobs::$_pluginpath . 'includes/images/resume/upload-icon.png" /></span>';
                        $field .= '</div>';
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'facebook':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->facebook) ? jsjobs::$_data[0]['personal_section']->facebook : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('facebook', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'googleplus':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->googleplus) ? jsjobs::$_data[0]['personal_section']->googleplus : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('googleplus', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'twitter':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->twitter) ? jsjobs::$_data[0]['personal_section']->twitter : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('twitter', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'linkedin':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->linkedin) ? jsjobs::$_data[0]['personal_section']->linkedin : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('linkedin', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'job_category':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->job_category) ? jsjobs::$_data[0]['personal_section']->job_category : JSJOBSincluder::getJSModel('category')->getDefaultCategoryId();
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('job_category', JSJOBSincluder::getJSModel('category')->getCategoryForCombobox(), $value, __('Select', 'js-jobs'), array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'jobtype':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->jobtype) ? jsjobs::$_data[0]['personal_section']->jobtype : JSJOBSincluder::getJSModel('jobtype')->getDefaultJobTypeId();
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('jobtype', JSJOBSincluder::getJSModel('jobtype')->getJobTypeForCombo(), $value, __('Select', 'js-jobs'), array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'heighestfinisheducation':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->heighestfinisheducation) ? jsjobs::$_data[0]['personal_section']->heighestfinisheducation : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('heighestfinisheducation', JSJOBSincluder::getJSModel('highesteducation')->getHighestEducationForCombo(), $value, __('Select','js-jobs') .'&nbsp;'. __('Highest Education', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'total_experience':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->experienceid) ? jsjobs::$_data[0]['personal_section']->experienceid : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('experienceid', JSJOBSincluder::getJSModel('experience')->getExperiencesForCombo(), $value, __('Select','js-jobs') .'&nbsp;'. __('Experience', 'js-jobs'), array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'section_moreoptions':
                        $sectionmoreoption = 1;
                        $html .= '<span class="resume-moreoptiontitle">' . __('Show More', 'js-jobs') . '<img src="' . jsjobs::$_pluginpath . 'includes/images/resume/down.png" /></span>
                                    <div class="resume-moreoption">';
                        break;
                    case 'date_of_birth':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->date_of_birth) ? jsjobs::$_data[0]['personal_section']->date_of_birth : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('date_of_birth', $value, array('class' => 'inputbox custom_date', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'date_start':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->date_start) ? jsjobs::$_data[0]['personal_section']->date_start : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('date_start', $value, array('class' => 'inputbox custom_date', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'salary':
                        $text = $this->getFieldTitleByField($field);
                        $rangestart = isset(jsjobs::$_data[0]['personal_section']->jobsalaryrangestart) ? jsjobs::$_data[0]['personal_section']->jobsalaryrangestart : '';
                        $rangeend = isset(jsjobs::$_data[0]['personal_section']->jobsalaryrangeend) ? jsjobs::$_data[0]['personal_section']->jobsalaryrangeend : '';
                        $rangetype = isset(jsjobs::$_data[0]['personal_section']->jobsalaryrangetype) ? jsjobs::$_data[0]['personal_section']->jobsalaryrangetype : '';
                        $currencyid = isset(jsjobs::$_data[0]['personal_section']->currencyid) ? jsjobs::$_data[0]['personal_section']->currencyid : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('jobsalaryrangestart', JSJOBSincluder::getJSModel('salaryrange')->getJobStartSalaryRangeForCombo(), $rangestart, __('Select','js-jobs') .'&nbsp;'. __('Salary Range','js-jobs') .'&nbsp'. __('Start', 'js-jobs'), array('class' => 'inputbox salarystart', 'data-validation' => $req));
                        $field .= JSJOBSformfield::select('jobsalaryrangeend', JSJOBSincluder::getJSModel('salaryrange')->getJobEndSalaryRangeForCombo(), $rangeend, __('Select','js-jobs') .'&nbsp;'. __('Salary Range','js-jobs') .'&nbsp;'. __('End', 'js-jobs'), array('class' => 'inputbox salaryend', 'data-validation' => $req));
                        $field .= JSJOBSformfield::select('jobsalaryrangetype', JSJOBSincluder::getJSModel('salaryrangetype')->getSalaryRangeTypesForCombo(), $rangetype, __('Select','js-jobs') .'&nbsp;'. __('Salary Range Type', 'js-jobs'), array('class' => 'inputbox salarytype', 'data-validation' => $req));
                        $field .= JSJOBSformfield::select('currencyid', JSJOBSincluder::getJSModel('currency')->getCurrencyForCombo(), $currencyid, __('Select','js-jobs') .'&nbsp;'. __('Currency', 'js-jobs'), array('class' => 'inputbox currency', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'desired_salary':
                        $text = $this->getFieldTitleByField($field);
                        $rangestart = isset(jsjobs::$_data[0]['personal_section']->desiredsalarystart) ? jsjobs::$_data[0]['personal_section']->desiredsalarystart : '';
                        $rangeend = isset(jsjobs::$_data[0]['personal_section']->desiredsalaryend) ? jsjobs::$_data[0]['personal_section']->desiredsalaryend : '';
                        $rangetype = isset(jsjobs::$_data[0]['personal_section']->djobsalaryrangetype) ? jsjobs::$_data[0]['personal_section']->djobsalaryrangetype : '';
                        $currencyid = isset(jsjobs::$_data[0]['personal_section']->dcurrencyid) ? jsjobs::$_data[0]['personal_section']->dcurrencyid : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('desiredsalarystart', JSJOBSincluder::getJSModel('salaryrange')->getJobStartSalaryRangeForCombo(), $rangestart, __('Select','js-jobs') .'&nbsp;'. __('Salary Range','js-jobs') .'&nbsp;'. __('Start', 'js-jobs'), array('class' => 'inputbox salarystart', 'data-validation' => $req));
                        $field .= JSJOBSformfield::select('desiredsalaryend', JSJOBSincluder::getJSModel('salaryrange')->getJobEndSalaryRangeForCombo(), $rangeend, __('Select','js-jobs') .'&nbsp;'. __('Salary Range','js-jobs') .'&nbsp;'. __('End', 'js-jobs'), array('class' => 'inputbox salaryend', 'data-validation' => $req));
                        $field .= JSJOBSformfield::select('djobsalaryrangetype', JSJOBSincluder::getJSModel('salaryrangetype')->getSalaryRangeTypesForCombo(), $rangetype, __('Select','js-jobs') .'&nbsp;'. __('Salary Range Type', 'js-jobs'), array('class' => 'inputbox salarytype', 'data-validation' => $req));
                        $field .= JSJOBSformfield::select('dcurrencyid', JSJOBSincluder::getJSModel('currency')->getCurrencyForCombo(), $currencyid, __('Select','js-jobs') .'&nbsp;'. __('Currency', 'js-jobs'), array('class' => 'inputbox currency', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'video':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->video) ? jsjobs::$_data[0]['personal_section']->video : '';
                        $vtype = isset(jsjobs::$_data[0]['personal_section']->videotype) ? jsjobs::$_data[0]['personal_section']->videotype : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $value = str_replace('\"', '', $value);
                        $field = JSJOBSformfield::radiobutton('videotype', array(1 => __('Youtube video Link', 'js-jobs'), 2 => __('Embeded html', 'js-jobs')), $vtype, array('class' => 'inputbox', 'data-validation' => $req));
                        $field .= JSJOBSformfield::text('video', $value, array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'keywords':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->keywords) ? jsjobs::$_data[0]['personal_section']->keywords : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('keywords', $value, array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'searchable':
                        $text = $this->getFieldTitleByField($field);
                        $value = (isset(jsjobs::$_data[0]['personal_section']->searchable) && jsjobs::$_data[0]['personal_section']->searchable == 1) ? 1 : 0;
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('searchable', JSJOBSincluder::getJSModel('common')->getYesNo(), $value, __('Searchable', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'iamavailable':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(jsjobs::$_data[0]['personal_section']->iamavailable) ? jsjobs::$_data[0]['personal_section']->iamavailable : '';
                        $req = ''; // for checking field is required or not
                        if ($required == 1) {
                            $text .= '<span style="color:red;">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::select('iamavailable', JSJOBSincluder::getJSModel('common')->getYesNo(), $value, __('Select','js-jobs') .'&nbsp;'. __('availablity', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    default:
                        // $array = (object) array('field' => $field , 'required' => $required , 'published' => 1); // always one published b/c check in model when getting fields
                        $i = 2;
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 1); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            if ($sectionmoreoption == 1) {
                $html .= '</div>'; // closing div for the more option
            }
            if(current_user_can('manage_options')){
                $text = __('Status','js-jobs');
                $value = (isset(jsjobs::$_data[0]['personal_section']->status) && jsjobs::$_data[0]['personal_section']->status == 1) ? 1 : '';
                $text .= '<span style="color:red;">*</span>';
                $req = 'required';
                $field = JSJOBSformfield::select('status', JSJOBSincluder::getJSModel('common')->getStatus(), $value, __('Select Status', 'js-jobs'), array('class' => 'inputbox', 'data-validation' => 'required'));
                $html .= $this->getRowForForm($text, $field);
            }
            $html .= '<input type="hidden" name="creditid" id="creditid" />';

            $config_array = JSJOBSincluder::getJSModel('configuration')->getConfigByFor('captcha');

            if (!is_user_logged_in() && $config_array['resume_captcha'] == 1) {
                $html .= '<div class="resume-row-wrapper form">
                            <div class="row-title">' . __('Captcha', 'js-jobs') . '</div>
                            <div class="row-value">';
                if ($config_array['captcha_selection'] == 1) { // Google recaptcha
                    $html .= '<div class="g-recaptcha" data-sitekey="'.$config_array["recaptcha_publickey"].'"></div>';

                } else { // own captcha
                    $captcha = new JSJOBScaptcha;
                    $html .= $captcha->getCaptchaForForm();
                }
                $html .= '  </div>
                        </div>';
            }

            $html .= '<div class="resume-section-button">
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            ';

            $guestallowed = 0;
            if (JSJOBSincluder::getObjectClass('jsjobsuser')->isguest()) {
                $guestallowed = JSJOBSincluder::getJSModel('configuration')->getConfigurationByConfigName('visitor_can_add_resume');
            }
            $html .= '<input type="button" onclick="submitresumesection(\'personal\',\'\');" value="' . __('Save', 'js-jobs') . '"/>';
            $html .= '<input type="button" onclick="cancelresumesection(\'personal\',\'\');" value="' . __('Cancel', 'js-jobs') . '"/>';
            $html .= '</div>';
            $html .= '</form>'; // section wrapper end;
            $html .= '</div>'; // section wrapper end;
        }
        return $html;
    }

    function getAddressesSection($resumeformview, $call, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            if (!empty(jsjobs::$_data[0]['address_section'][0]))
                foreach (jsjobs::$_data[0]['address_section'] AS $address) {
                    $html .= '<div class="section_wrapper" data-section="addresses" data-sectionid="' . $address->id . '">';
                    $i = 0;
                    $loc = 0;
                    $value = $address->address;
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value);
                    foreach (jsjobs::$_data[2][2] AS $field => $required) {
                        switch ($field) {
                            case 'address_city':
                            case 'address_state':
                            case 'address_country':
                                if ($loc == 0) {
                                    $text = $this->getFieldTitleByField($field);
                                    $value = JSJOBSincluder::getJSModel('common')->getLocationForView($address->cityname, $address->statename, $address->countryname);
                                    $html .= $this->getRowForView($text, $value, $i);
                                    $loc++;
                                }
                                break;
                            case 'address_zipcode':
                                $text = $this->getFieldTitleByField($field);
                                $value = $address->address_zipcode;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'address_location':
                                $text = $this->getFieldTitleByField($field);
                                $html .= $this->getRowMapForView($text, $address->longitude, $address->latitude);
                                break;
                            default:
                                $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, $address->params); //11 for view resume
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i);
                                break;
                        }
                    }
                    if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                        $html .= '</div>';
                    }
                    $html .= '</div>'; //section wrapper end;
                }
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $address = isset(jsjobs::$_data[0]['address_section']) ? jsjobs::$_data[0]['address_section'] : '';
            $addressid = isset($address->id) ? $address->id : '';
            $html .= '<div class="section_wrapper form" data-section="addresses" data-sectionid="' . $addressid . '">';
            $imgtxt = isset($address->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Address', 'js-jobs') . '</div>';
            $html .= '<form>';
            $k = 0;
            $loc = 0;
            foreach (jsjobs::$_data[2][2] AS $field => $required) {
                switch ($field) {
                    case 'address':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($address->address) ? $address->address : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('address', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'address_city':
                    case 'address_state':
                    case 'address_country':
                        if ($loc == 0) {
                            $text = $this->getFieldTitleByField($field);
                            $value = '';
                            $valueedit = '';
                            if (isset($address->address_city)) {
                                $value = $address->address_city;
                                $location = JSJOBSincluder::getJSModel('common')->getLocationForView($address->cityname, $address->statename, $address->countryname);
                                $valueedit = json_encode(array('id' => $address->address_city, 'name' => $location));
                            }
                            $req = ''; // for checking the required field
                            if ($required == 1) {
                                $text .= '<span style="color:red">*</span>';
                                $req = 'required';
                            }
                            $field = JSJOBSformfield::text('address_city', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                            $field .= "<input type='hidden' name='addresscityforedit' id='addresscityforedit' value='" . $valueedit . "' />";
                            $html .= $this->getRowForForm($text, $field);
                            $html .= '  <script type="text/javascript">
                                            getTokenInput("address_city","addresscityforedit");
                                        </script>';
                            $loc++;
                        }
                        break;
                    case 'address_zipcode':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($address->address_zipcode) ? $address->address_zipcode : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('address_zipcode', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'address_location':
                        $text = $this->getFieldTitleByField($field);
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        if (isset($address->longitude) && isset($address->latitude)) {
                            $latitude = $address->latitude;
                            $longitude = $address->longitude;
                        } else {
                            $latitude = jsjobs::$_configuration['default_latitude'];
                            $longitude = jsjobs::$_configuration['default_longitude'];
                        }
                        $html .= $this->getRowMapForEdit($text, $longitude, $latitude);
                        //$html .= $this->getRowForView($text,$value);
                        break;
                    default:
                        $i = 0;
                        if (isset($address->id)) {
                            $var = $address->id;
                        } else {
                            $var = '';
                        }
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 2, $var); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'addresses\',\'' . $addressid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'addresses\',\'' . $addressid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>'; //section wrapper end;
            $html .= '</div>'; //section wrapper end;
        }
        return $html;
    }

    function getEducationSection($resumeformview, $call, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            if (!empty(jsjobs::$_data[0]['institute_section'][0]))
                foreach (jsjobs::$_data[0]['institute_section'] AS $institute) {
                    $html .= '<div class="section_wrapper" data-section="institutes" data-sectionid="' . $institute->id . '">';
                    $i = 0;
                    $value = $institute->institute;
                    if ($institute->iscontinue == 1) {
                        $todate = __('Continue', 'js-jobs');
                    } else {
                        $todate = date_i18n('M Y', strtotime($institute->todate));
                    }
                    $value .= '<span class="resume-employer-dates">(' . date_i18n('M Y', strtotime($institute->fromdate)) . ' - ' . $todate . ')</span>';
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value);
                    foreach (jsjobs::$_data[2][3] AS $field => $required) {
                        switch ($field) {
                            case 'institute_city':
                                $text = $this->getFieldTitleByField($field);
                                $value = JSJOBSincluder::getJSModel('common')->getLocationForView($institute->cityname, $institute->statename, $institute->countryname);
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'institute_address':
                                $text = $this->getFieldTitleByField($field);
                                $value = $institute->institute_address;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'institute_certificate_name':
                                $text = $this->getFieldTitleByField($field);
                                $value = $institute->institute_certificate_name;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'institute_study_area':
                                $text = $this->getFieldTitleByField($field);
                                $value = $institute->institute_study_area;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            default:
                                $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, $institute->params); //11 for view resume
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i);
                                break;
                        }
                    }
                    if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                        $html .= '</div>';
                    }
                    $html .= '</div>'; // section wrapper end;
                }
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $institute = isset(jsjobs::$_data[0]['institute_section']) ? jsjobs::$_data[0]['institute_section'] : '';
            $instituteid = isset($institute->id) ? $institute->id : '';
            $html .= '<div class="section_wrapper form" data-section="institutes" data-sectionid="' . $instituteid . '">';
            $imgtxt = isset($institute->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Education', 'js-jobs') . '</div>';
            $html .= '<form>';
            $k = 0;
            foreach (jsjobs::$_data[2][3] AS $field => $required) {
                switch ($field) {
                    case 'institute':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($institute->institute) ? $institute->institute : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('institute', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'institute_city':
                        $text = $this->getFieldTitleByField($field);
                        $value = '';
                        $valueedit = '';
                        if (isset($institute->institute_city)) {
                            $value = $institute->institute_city;
                            $location = JSJOBSincluder::getJSModel('common')->getLocationForView($institute->cityname, $institute->statename, $institute->countryname);
                            $valueedit = json_encode(array('id' => $institute->institute_city, 'name' => $location));
                        }
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('institute_city', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $field .= "<input type='hidden' name='institute_cityforedit' id='institute_cityforedit' value='" . $valueedit . "' />";
                        $html .= $this->getRowForForm($text, $field);
                        $html .= '  <script type="text/javascript">
                                        getTokenInput("institute_city","institute_cityforedit");
                                    </script>';
                        break;
                    case 'institute_address':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($institute->institute_address) ? $institute->institute_address : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('institute_address', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'institute_certificate_name':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($institute->institute_certificate_name) ? $institute->institute_certificate_name : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('institute_certificate_name', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'institute_study_area':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($institute->institute_study_area) ? $institute->institute_study_area : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('institute_study_area', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    default:
                        $i = 0;
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 3, $instituteid); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'institutes\',\'' . $instituteid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'institutes\',\'' . $instituteid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>'; // section wrapper end;
            $html .= '</div>'; // section wrapper end;
        }
        return $html;
    }

    function getEmployerSection($resumeformview, $call, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            if (!empty(jsjobs::$_data[0]['employer_section'][0]))
                foreach (jsjobs::$_data[0]['employer_section'] AS $employer) {
                    $html .= '<div class="section_wrapper" data-section="employers" data-sectionid="' . $employer->id . '">';
                    $i = 0;
                    $value = $employer->employer;
                    $value .= '<span class="resume-employer-position">' . $employer->employer_position . '</span>';
                    $value .= '<span class="resume-employer-dates">(' . date_i18n('M Y', strtotime($employer->employer_from_date)) . ' - ' . date_i18n('M Y', strtotime($employer->employer_to_date)) . ')</span>';
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value);
                    foreach (jsjobs::$_data[2][4] AS $field => $required) {
                        switch ($field) {
                            case 'employer_resp':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_resp;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_pay_upon_leaving':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_pay_upon_leaving;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_supervisor':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_supervisor;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_leave_reason':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_leave_reason;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_city':
                                $text = $this->getFieldTitleByField($field);
                                $value = JSJOBSincluder::getJSModel('common')->getLocationForView($employer->cityname, $employer->statename, $employer->countryname);
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_zip':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_zip;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_phone':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_phone;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'employer_address':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_address;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            default:
                                $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, $employer->params); //11 for view resume
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i);
                                break;
                        }
                    }
                    if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                        $html .= '</div>';
                    }
                    $html .= '</div>'; // section wrapper end;
                }
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $employer = isset(jsjobs::$_data[0]['employer_section']) ? jsjobs::$_data[0]['employer_section'] : '';
            $employerid = isset($employer->id) ? $employer->id : '';
            $html .= '<div class="section_wrapper form" data-section="employers" data-sectionid="' . $employerid . '">';
            $imgtxt = isset($employer->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Employer', 'js-jobs') . '</div>';
            $html .= '<form>';
            $k = 0;
            $loc = 0;
            foreach (jsjobs::$_data[2][4] AS $field => $required) {
                switch ($field) {
                    case 'employer':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer) ? $employer->employer : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_position':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_position) ? $employer->employer_position : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_position', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_resp':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_resp) ? $employer->employer_resp : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_resp', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_pay_upon_leaving':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_pay_upon_leaving) ? $employer->employer_pay_upon_leaving : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_pay_upon_leaving', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_supervisor':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_supervisor) ? $employer->employer_supervisor : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_supervisor', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_from_date':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_from_date) ? $employer->employer_from_date : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_from_date', $value, array('class' => 'inputbox custom_date', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_to_date':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_to_date) ? $employer->employer_to_date : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_to_date', $value, array('class' => 'inputbox custom_date', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_leave_reason':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_leave_reason) ? $employer->employer_leave_reason : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_leave_reason', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_city':
                        if ($loc == 0) {
                            $text = $this->getFieldTitleByField($field);
                            $value = '';
                            $valueedit = '';
                            if (isset($employer->employer_city)) {
                                $value = $employer->employer_city;
                                $location = JSJOBSincluder::getJSModel('common')->getLocationForView($employer->cityname, $employer->statename, $employer->countryname);
                                $valueedit = json_encode(array('id' => $employer->employer_city, 'name' => $location));
                            }
                            $req = ''; // for checking the required field
                            if ($required == 1) {
                                $text .= '<span style="color:red">*</span>';
                                $req = 'required';
                            }
                            $field = JSJOBSformfield::text('employer_city', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                            $field .= "<input type='hidden' name='employercityforedit' id='employercityforedit' value='" . $valueedit . "' />";
                            $html .= $this->getRowForForm($text, $field);
                            $html .= '  <script type="text/javascript">
                                            getTokenInput("employer_city","employercityforedit");
                                        </script>';
                            $loc++;
                        }
                        break;
                    case 'employer_zip':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_zip) ? $employer->employer_zip : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_zip', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_phone':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_phone) ? $employer->employer_phone : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_phone', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'employer_address':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($employer->employer_address) ? $employer->employer_address : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('employer_address', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    default:
                        $i = 0;
                        if (isset($employer->id)) {
                            $var = $employer->id;
                        } else {
                            $var = '';
                        }
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 4, $var); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'employers\',\'' . $employerid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'employers\',\'' . $employerid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>';
            $html .= '</div>';
        }
        return $html;
    }

    function getSkillSection($resumeformview, $call, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            $html .= '<div class="section_wrapper" data-section="skills" data-sectionid="">';
            $i = 0;
            foreach (jsjobs::$_data[2][5] AS $field => $required) {
                switch ($field) {
                    case 'skills':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        $value = jsjobs::$_data[0]['personal_section']->skills;
                        $html .= '<div class="resume-section-data">' . $value . '</div>';
                        $i = 0;
                        break;
                    default:
                        $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, jsjobs::$_data[0]['personal_section']->params); //11 for view resume
                        if (is_array($array))
                            $html .= $this->getRowForView($array['title'], $array['value'], $i);
                        break;
                }
            }
            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                $html .= '</div>';
            }
            $html .= '</div>'; // section wrapper end;
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $text = $this->getFieldTitleByField('skills');
            $value = isset(jsjobs::$_data[0]['personal_section']->skills) ? jsjobs::$_data[0]['personal_section']->skills : '';
            $skillid = isset(jsjobs::$_data[0]['personal_section']->id) ? jsjobs::$_data[0]['personal_section']->id : '';
            $html .= '<div class="section_wrapper form" data-section="skills" data-sectionid="' . $skillid . '">';
            $imgtxt = isset(jsjobs::$_data[0]['personal_section']->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Skills', 'js-jobs') . '</div>';
            $html .= '<form>';
            $req = ''; // for checking the required field
            if (jsjobs::$_data[2][5]['skills'] == 1) {
                $text .= '<span style="color:red">*</span>';
                $req = 'required';
            }

            $i = 0;
            $k = 0;
            foreach (jsjobs::$_data[2][5] AS $field => $required) {
                switch ($field) {
                    case 'skills':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        $field = JSJOBSformfield::textarea('skills', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        $i = 0;
                        break;
                    default:
                        $i = 0;
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 5, $skillid); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                $html .= '</div>'; // closing div for the more option
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'skills\',\'' . $skillid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'skills\',\'' . $skillid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>';
            $html .= '</div>';
        }elseif($call == 0){
            $html .= '<div data-section="skills"></div>';
        }
        return $html;
    }

    function getResumeSection($resumeformview, $call, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            $html .= '<div class="section_wrapper" data-section="resume" data-sectionid="">';
            $i = 0;
            foreach (jsjobs::$_data[2][6] AS $field => $required) {
                switch ($field) {
                    case 'resume':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        $value = jsjobs::$_data[0]['personal_section']->resume;
                        $html .= '<div class="resume-section-data">' . $value . '</div>';
                        $i = 0;
                        break;
                    default:
                        $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11,jsjobs::$_data[0]['personal_section']->params); //11 for view resume
                        if (is_array($array))
                            $html .= $this->getRowForView($array['title'], $array['value'], $i);
                        break;
                }
            }
            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                $html .= '</div>'; // closing div for the more option
            }
            $html .= '</div>';
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $text = $this->getFieldTitleByField('resume');
            $value = isset(jsjobs::$_data[0]['personal_section']->resume) ? jsjobs::$_data[0]['personal_section']->resume : '';
            $resumeid = isset(jsjobs::$_data[0]['personal_section']->id) ? jsjobs::$_data[0]['personal_section']->id : '';
            $html .= '<div class="section_wrapper form" data-section="resume" data-sectionid="' . $resumeid . '">';
            $imgtxt = isset(jsjobs::$_data[0]['personal_section']->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Resume', 'js-jobs') . '</div>';
            $html .= '<form>';
            $req = ''; // for checking the required field
            if (jsjobs::$_data[2][6]['resume'] == 1) {
                $text .= '<span style="color:red">*</span>';
                $req = 'required';
            }
            $i = 0;
            $k = 0;
            foreach (jsjobs::$_data[2][6] AS $field => $required) {
                switch ($field) {
                    case 'resume':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        // $field = wp_editor($value, 'resume', array('data-validation' => $req,'tinymce'=>true , 'media_buttons' => true , 'teeny' => false));
                        $field = JSJOBSformfield::textarea('resume', $value, array('class' => 'inputbox one resumeeditor', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        $i = 0;
                        break;
                    default:
                        $i = 0;
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 6); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                $html .= '</div>'; // closing div for the more option
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'resume\',\'' . $resumeid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'resume\',\'' . $resumeid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>';
            $html .= '</div>';
        } elseif($call == 0){
            $html .= '<div data-section="resume"></div>';
        }
        return $html;
    }

    function getReferenceSection($resumeformview, $call, $viewlayout = 0) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            if (!empty(jsjobs::$_data[0]['reference_section'][0]))
                foreach (jsjobs::$_data[0]['reference_section'] AS $reference) {
                    $html .= '<div class="section_wrapper" data-section="references" data-sectionid="' . $reference->id . '">';
                    $i = 0;
                    $loc = 0;
                    $value = $reference->reference;
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value);
                    foreach (jsjobs::$_data[2][7] AS $field => $required) {
                        switch ($field) {
                            case 'reference_name':
                                $text = $this->getFieldTitleByField($field);
                                $value = $reference->reference_name;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'reference_state':
                            case 'reference_country':
                            case 'reference_city':
                                if ($loc == 0) {
                                    $text = $this->getFieldTitleByField($field);
                                    $value = JSJOBSincluder::getJSModel('common')->getLocationForView($reference->cityname, $reference->statename, $reference->countryname);
                                    $html .= $this->getRowForView($text, $value, $i);
                                    $loc++;
                                }
                                break;
                            case 'reference_zipcode':
                                $text = $this->getFieldTitleByField($field);
                                $value = $reference->reference_zipcode;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'reference_address':
                                $text = $this->getFieldTitleByField($field);
                                $value = $reference->reference_address;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'reference_phone':
                                $text = $this->getFieldTitleByField($field);
                                $value = $reference->reference_phone;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'reference_relation':
                                $text = $this->getFieldTitleByField($field);
                                $value = $reference->reference_relation;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'reference_years':
                                $text = $this->getFieldTitleByField($field);
                                $value = $reference->reference_years;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            default:
                                $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, $reference->params); //6 for view resume and 2 for resume section
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i);
                                break;
                        }
                    }
                    if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                        $html .= '</div>';
                    }
                    $html .= '</div>'; //section wrapper end;
                }
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $reference = isset(jsjobs::$_data[0]['reference_section']) ? jsjobs::$_data[0]['reference_section'] : '';
            $referenceid = isset($reference->id) ? $reference->id : '';
            $html .= '<div class="section_wrapper form" data-section="references" data-sectionid="' . $referenceid . '">';
            $imgtxt = isset($reference->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('References', 'js-jobs') . '</div>';
            $html .= '<form>';
            $k = 0;
            $loc = 0;
            foreach (jsjobs::$_data[2][7] AS $field => $required) {
                switch ($field) {
                    case 'reference':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference) ? $reference->reference : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'reference_name':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference_name) ? $reference->reference_name : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference_name', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'reference_city':
                    case 'reference_state':
                    case 'reference_country':
                        if ($loc == 0) {
                            $text = $this->getFieldTitleByField($field);
                            $value = '';
                            $valueedit = '';
                            if (isset($reference->reference_city)) {
                                $value = $reference->reference_city;
                                $location = JSJOBSincluder::getJSModel('common')->getLocationForView($reference->cityname, $reference->statename, $reference->countryname);
                                $valueedit = json_encode(array('id' => $reference->reference_city, 'name' => $location));
                            }
                            $req = ''; // for checking the required field
                            if ($required == 1) {
                                $text .= '<span style="color:red">*</span>';
                                $req = 'required';
                            }
                            $field = JSJOBSformfield::text('reference_city', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                            $field .= "<input type='hidden' name='referencecityforedit' id='referencecityforedit' value='" . $valueedit . "' />";
                            $html .= $this->getRowForForm($text, $field);
                            $html .= '  <script type="text/javascript">
                                            getTokenInput("reference_city","referencecityforedit");
                                        </script>';
                            $loc++;
                        }
                        break;
                    case 'reference_zipcode':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference_zipcode) ? $reference->reference_zipcode : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference_zipcode', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'reference_address':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference_address) ? $reference->reference_address : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference_address', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'reference_phone':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference_phone) ? $reference->reference_phone : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference_phone', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'reference_relation':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference_relation) ? $reference->reference_relation : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference_relation', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'reference_years':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($reference->reference_years) ? $reference->reference_years : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('reference_years', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    default:
                        $i = 0;
                        if (isset($reference->id)) {
                            $var = $reference->id;
                        } else {
                            $var = '';
                        }
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 7, $var); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'references\',\'' . $referenceid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'references\',\'' . $referenceid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>';
            $html .= '</div>';
        }
        return $html;
    }

    function getLanguageSection($resumeformview, $call, $viewlayout = 0) { // viewlayout use to use only on view resume  
        $html = '';
        if ($resumeformview == 0) { // edit form
            if (!empty(jsjobs::$_data[0]['language_section'][0]))
                foreach (jsjobs::$_data[0]['language_section'] AS $language) {
                    $html .= '<div class="section_wrapper" data-section="languages" data-sectionid="' . $language->id . '">';
                    $i = 0;
                    $value = $language->language;
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . jsjobs::$_pluginpath . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value);
                    foreach (jsjobs::$_data[2][8] AS $field => $required) {
                        switch ($field) {
                            case 'language_reading':
                                $text = $this->getFieldTitleByField($field);
                                $value = $language->language_reading;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'language_writing':
                                $text = $this->getFieldTitleByField($field);
                                $value = $language->language_writing;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'language_understanding':
                                $text = $this->getFieldTitleByField($field);
                                $value = $language->language_understanding;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            case 'language_where_learned':
                                $text = $this->getFieldTitleByField($field);
                                $value = $language->language_where_learned;
                                $html .= $this->getRowForView($text, $value, $i);
                                break;
                            default:
                                $array = JSJOBSincluder::getObjectClass('customfields')->showCustomFields($field, 11, $language->params); //11 for view resume
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i);
                                break;
                        }
                    }
                    if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                        $html .= '</div>';
                    }
                    $html .= '</div>'; //section wrapper end;
                }
        } elseif ($call == 1) { // new form and not to show form if call == 1 b/c in new form we add the add button
            $language = isset(jsjobs::$_data[0]['language_section']) ? jsjobs::$_data[0]['language_section'] : '';
            $languageid = isset($language->id) ? $language->id : '';
            $html .= '<div class="section_wrapper form" data-section="languages" data-sectionid="' . $languageid . '">';
            $imgtxt = isset($language->id) ? '<img src="' . jsjobs::$_pluginpath . 'includes/images/edit-resume.png">' . __('Edit', 'js-jobs') : ' + ' . __('Add', 'js-jobs');
            $html .= '<div class="formsectionheading">' . $imgtxt . ' ' . __('Language', 'js-jobs') . '</div>';
            $html .= '<form>';
            $i = 0;
            $k = 0; // user fields
            foreach (jsjobs::$_data[2][8] AS $field => $required) {
                switch ($field) {
                    case 'language':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($language->language) ? $language->language : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('language', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'language_reading':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($language->language_reading) ? $language->language_reading : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('language_reading', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'language_writing':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($language->language_writing) ? $language->language_writing : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('language_writing', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'language_understanding':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($language->language_understanding) ? $language->language_understanding : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('language_understanding', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    case 'language_where_learned':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset($language->language_where_learned) ? $language->language_where_learned : '';
                        $req = ''; // for checking the required field
                        if ($required == 1) {
                            $text .= '<span style="color:red">*</span>';
                            $req = 'required';
                        }
                        $field = JSJOBSformfield::text('language_where_learned', $value, array('class' => 'inputbox one', 'data-validation' => $req));
                        $html .= $this->getRowForForm($text, $field);
                        break;
                    default:
                        $i = 0;
                        if (isset($language->id)) {
                            $var = $language->id;
                        } else {
                            $var = '';
                        }
                        $html .= JSJOBSincluder::getObjectClass('customfields')->formCustomFields($field, 1, 8, $var); //first 1 is to tell that it is resume form and second is to tell which section of resume form
                        break;
                }
            }
            $html .= '<div class="resume-section-button"><input type="button" onclick="submitresumesection(\'languages\',\'' . $languageid . '\');" value="' . __('Save', 'js-jobs') . '"/><input type="button" onclick="cancelresumesection(\'languages\',\'' . $languageid . '\');" value="' . __('Cancel', 'js-jobs') . '"/></div>';
            $html .= '</form>'; // section wrapper end;
            $html .= '</div>'; // section wrapper end;
        }
        return $html;
    }

    function getRowMapForEdit($text, $longitude, $latitude) {
        $id = uniqid();
        $html = '<div class="resume-map-edit">
                    <div class="row-title">' . $text . '</div>
                    <div class="row-value">
                        <input type="text" id="latitude_' . $id . '" name="latitude" value="' . $latitude . '" />
                        <input type="text" id="longitude_' . $id . '" name="longitude" value="' . $longitude . '" />
                        <div id="' . $id . '" class="map" style="width:100%;min-height:200px;">' . $longitude . ' - ' . $latitude . '</div>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function(){                            
                            initializeEdit("' . $latitude . '","' . $longitude . '","' . $id . '");
                        });                        
                    </script>
                </div>';
        return $html;
    }

    function getRowMapForView($text, $longitude, $latitude) {
        $id = uniqid();
        $html = '<div class="resume-map">
                    <div class="row-title"><img src="' . jsjobs::$_pluginpath . 'includes/images/resume/hide-map.png" class="image"/>' . $text . '</div>
                    <div class="row-value"><div id="' . $id . '" class="map" style="width:100%;min-height:200px;">' . $longitude . ' - ' . $latitude . '</div></div>
                    <script type="text/javascript" id="script_' . $id . '">
                        initialize("' . $latitude . '","' . $longitude . '","' . $id . '");
                    </script>
                </div>';
        return $html;
    }

    function getRowForVideoView($text, $value, $vtype) {
        $html = '<div class="resume-row-full-view">
                    <div class="row-value video">';
        if (!empty($value)) {
            if ($vtype == 1 && !empty($my_array_of_vars)) { // youtube video link
                parse_str(parse_url($value, PHP_URL_QUERY), $my_array_of_vars);
                $value = $my_array_of_vars['v'];
                $html .= '<iframe title="YouTube video player" width="380" height="290" 
                                src="http://www.youtube.com/embed/' . $value . '" frameborder="0" allowfullscreen>
                        </iframe>';
            } else { //Embed code
                $html .= str_replace('\"', '', $value);
            }
        }
        $html .= '</div>
                </div>';
        return $html;
    }

    function getAttachmentRowForView($text) {
        $html = '<div class="resume-row-full-view">
                    <div class="row-title attachments">' . $text . ':</div>
                    <div class="row-value attachments">';
        if (!empty(jsjobs::$_data[0]['file_section'])) {
            foreach (jsjobs::$_data[0]['file_section'] AS $file) {
                $html .= '<a target="_blank" href="' . site_url('?page_id=' . jsjobs::getPageid() . '&jsjobsme=resume&action=jstask&task=getresumefiledownloadbyid&jsjobsid=' . $file->id) . '" class="file">
                            <span class="filename">' . $file->filename . '</span><span class="fileext"></span>
                            <img class="filedownload" src="' . jsjobs::$_pluginpath . 'includes/images/resume/download.png" />
                        </a>';
            }
        }
        $html .= '  </div>
                </div>';
        return $html;
    }

    function getRowForView($text, $value, &$i) {
        $html = '';
        if ($i == 0 || $i % 2 == 0) {
            $html .= '<div class="resume-row-wrapper-wrapper">';
        }
        $html .= '<div class="resume-row-wrapper">
                    <div class="row-title">' . $text . ':</div>
                    <div class="row-value">' . __($value,'js-jobs') . '</div>
                </div>';
        $i++;
        if ($i % 2 == 0) {
            $html .= '</div>';
        }
        return $html;
    }

    function getRowForForm($text, $value) {
        $html = '<div class="resume-row-wrapper form">
                    <div class="row-title">' . $text . ':</div>
                    <div class="row-value">' . $value . '</div>
                </div>';
        return $html;
    }

    function getHeadingRowForView($value) {
        $html = '<div class="resume-heading-row">' . $value . '</div>';
        return $html;
    }

}

?>
