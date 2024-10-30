<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSJOBSresumeinstituteTable extends JSJOBStable {

    public $id = '';
    public $resumeid = '';
    public $institute = '';
    public $institute_country = '';
    public $institute_state = '';
    public $institute_city = '';
    public $institute_address = '';
    public $institute_certificate_name = '';
    public $institute_study_area = '';
    public $created = '';
    public $last_modified = '';
    public $params = '';

    public function check() {
        if ($this->resumeid == '') {
            return false;
        }

        return true;
    }

    function __construct() {
        parent::__construct('resumeinstitutes', 'id'); // tablename, primarykey
    }

}

?>