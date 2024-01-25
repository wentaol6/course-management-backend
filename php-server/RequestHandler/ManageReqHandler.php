<?php
require_once 'IRequestHandler.php';
require_once __DIR__ . '/../Database/SingleTableCRUDHandler.php';


class ManageReqHandler implements IRequestHandler {

    public function HandleRequest(ReqMsg $reqMsg) {
        switch ($reqMsg->getMethod()) {
            case 'GET':
                $this->Read($reqMsg);
                break;
            case 'POST':
                $this->Create($reqMsg);
                break;
            case 'PUT':
                $this->Update($reqMsg);
                break;
            case 'DELETE':
                $this->Delete($reqMsg);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                exit;
        }
    }

    private function Read(ReqMsg $reqMsg) {
        $params = $reqMsg->GetParam();
        SingleTableCRUDHandler::Read($params['table'], $params['searchKey'], $params['searchValue']);
    }

    private function Create(ReqMsg $reqMsg) {
        SingleTableCRUDHandler::Create($reqMsg->GetParam()['table'], $reqMsg->GetBody());
    }

    private function Update(ReqMsg $reqMsg) {
        $params = $reqMsg->GetParam();
        SingleTableCRUDHandler::Update($params['table'], $params['searchKey'], $params['searchValue'], $reqMsg->GetBody());
    }

    private function Delete(ReqMsg $reqMsg) {
        $params = $reqMsg->GetParam();
        SingleTableCRUDHandler::Delete($params['table'], $params['searchKey'], $params['searchValue']);
    }
}