<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSJobsUser {

    private $currentuser = null;

    function __construct() {
        if (is_user_logged_in()) { // wp user logged in
            $wpuserid = get_current_user_id();
            if (!is_numeric($wpuserid))
                return false;
            $query = "SELECT * FROM `" . jsjobs::$_db->prefix . "js_job_users` WHERE uid = " . $wpuserid;
            $this->currentuser = jsjobs::$_db->get_row($query);
        }else { // wp user is not logged in
            if (isset($_SESSION['jsjobs-socialid']) && !empty($_SESSION['jsjobs-socialid'])) { // social user is logged in
                $query = "SELECT * FROM `" . jsjobs::$_db->prefix . "js_job_users` WHERE socialid = '" . $_SESSION['jsjobs-socialid'] . "'";
                $this->currentuser = jsjobs::$_db->get_row($query);
            }
        }
    }

    function isguest() {
        if (isset($_SESSION['jsjobs-socialid']) && !empty($_SESSION['jsjobs-socialid'])) {
            return false;
        } elseif ($this->currentuser == null && !is_user_logged_in()) { // current user is guest
            return true;
        } else {
            return false;
        }
    }

    function isdisabled() {
        if ($this->currentuser != null && $this->currentuser->status == 0) { // current user is disabled
            return true;
        } else {
            return false;
        }
    }

    function isemployer() {
        if ($this->currentuser == null) { // current user is guest
            return false;
        } else {
            if ($this->currentuser->roleid == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function isjobseeker() {
        if ($this->currentuser == null) { // current user is guest
            return false;
        } else {
            if ($this->currentuser->roleid == 2) {
                return true;
            } else {
                return false;
            }
        }
    }

    function uid() {
        if ($this->currentuser != null) {
            return $this->currentuser->id;
        }
    }

    function emailaddress() {
        if ($this->currentuser == null) { // current user is guest
            return false;
        } else {
            return $this->currentuser->emailaddress;
        }
    }

    function fullname() {
        if ($this->currentuser == null) { // current user is guest
            return false;
        } else {
            $name = $this->currentuser->first_name . ' ' . $this->currentuser->last_name;
            return $name;
        }
    }

    function isJSJobsUser() {
        if (is_user_logged_in()) { // wp user logged in
            $wpuserid = get_current_user_id();
            if (!is_numeric($wpuserid))
                return false;
            $query = "SELECT COUNT(id) FROM `" . jsjobs::$_db->prefix . "js_job_users` WHERE uid = " . $wpuserid;
            $result = jsjobs::$_db->get_var($query);
            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    
    function getjsjobsuidbyuserid($userid){
        if(!is_numeric($userid)) return false;
        $query = "SELECT id FROM `".jsjobs::$_db->prefix."js_job_users` WHERE uid = ".$userid;
        $uid = jsjobs::$_db->get_var($query);
        return $uid;
    }

}

?>