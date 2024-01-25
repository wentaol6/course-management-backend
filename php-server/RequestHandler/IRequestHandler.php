<?php
interface IRequestHandler {
    public function HandleRequest(ReqMsg $reqMsg);
}