<?php

declare(strict_types=1);

namespace App\controller\frontend;

use Eric\Core\Action;
use Eric\Core\View;
use Exception;

/**
 * Class Home
 */
class Home extends Action
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $title;

    protected $view;

    public function __construct() {
        $this->title = "Home Page";
        $this->template = 'homepage';
    }

    /**
     * @param $args
     * @return void
     * @throws Exception
     */
    public function execute($args)
    {
        $this->view = new View($this->template);
        $data = [$args];
        $this->view->assign('data', $data);
        $this->view->render();
    }
}