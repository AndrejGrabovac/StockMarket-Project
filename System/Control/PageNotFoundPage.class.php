<?php

class PageNotFoundPage extends AbstractPage
{
    public $templateName = 'pagenotfound';

    public function execute()
    {
        $requestedPage = isset($_GET['page']) ? $_GET['page'] : 'unknown';

        $this->data = [
            'status' => 'error',
            'message' => "The requested page '$requestedPage' was not found",
        ];
    }
}