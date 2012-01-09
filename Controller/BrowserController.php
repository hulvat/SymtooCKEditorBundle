<?php

namespace Symtoo\CKEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrowserController extends Controller
{
    public function connectAction()
    {
        require_once(__DIR__.'/../Connector/connector.php');
        exit;
    }
}