<?php
namespace Backup;

use Common\Bmvc\BaseView;

class View extends BaseView {
    public function __construct() {
        parent::__construct();
        $this->templatePath = dirname(__FILE__) . '/templates/';
    }

    protected function getLayoutData() {
        return [
            'title' => 'Backup Management',
            'currentModule' => 'backup'
        ];
    }
}
