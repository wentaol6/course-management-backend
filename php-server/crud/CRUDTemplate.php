<?php

// CRUD Template

abstract class CRUDTemplate {
    protected $reqMsg;
    protected $conn;

    public function __construct($reqMsg, $conn) {
        $this->reqMsg = $reqMsg;
        $this->conn = $conn;
    }

    public function handleRequest($reqMsg) {
        switch ($reqMsg->getMethod()) {
            case 'GET':
                $this->read();
                break;
            case 'POST':
                $this->create();
                break;
            case 'PUT':
                $this->update();
                break;
            case 'DELETE':
                $this->delete();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                exit;
        }
    }

    protected abstract function create();
    protected abstract function read();
    protected abstract function update();
    protected abstract function delete();
}
