<?php
// CRUDFactory.php

require_once 'classes/CRUDTemplate.php';
require_once 'classes/UsersCRUD.php';
require_once 'classes/CoursesCRUD.php';
require_once 'classes/EnrolmentsCRUD.php';

class CRUDFactory {
    public static function createCRUD($type, $conn) {
        switch ($type) {
            case 'users':
                // return new UsersCRUD($conn);
            case 'courses':
                // return new CoursesCRUD($conn);
            case 'enrolments':
                // return new EnrolmentsCRUD($conn);
            default:
                throw new Exception("Invalid CRUD type");
        }
    }
}
