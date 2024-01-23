<?php
// CRUDFactory.php

require_once 'CRUDTemplate.php';
require_once 'UsersCRUD.php';
require_once 'CoursesCRUD.php';
require_once 'EnrolmentsCRUD.php';


class CRUDFactory {
    public static function createCRUD($reqMsg, $conn) {
        switch ($reqMsg->getPath()) {
            case '/php-server/users':
                return new UsersCRUD($reqMsg, $conn);
            case '/php-server/courses':
                return new CoursesCRUD($reqMsg, $conn);
            case '/php-server/enrolments':
                return new EnrolmentsCRUD($reqMsg, $conn);
            default:
                throw new Exception("Invalid CRUD type");
        }
    }
}
