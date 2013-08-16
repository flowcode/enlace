<?php

namespace flowcode\wing\mvc\view;

use flowcode\wing\mvc\config\Config;
use flowcode\wing\mvc\exception\ViewException;

/**
 * Description of View
 *
 * @author juanma
 */
class View implements IView {

    protected $viewData;
    protected $viewName;

    function __construct($viewData, $viewName = NULL) {
        $this->viewName = $viewName;
        $this->viewData = $viewData;
    }

    public function render() {
        $viewConfig = Config::get("view");
        $viewRootPath = $viewConfig["path"];
        $settedMaster = null;

        /* set view data available */
        $viewData = $this->viewData;

        /* with master */
        $viewfile = $viewRootPath . "/" . $this->getViewName() . ".view.php";
        if (file_exists($viewfile)) {
            ob_start();
            require_once $viewfile;
            $content = ob_get_contents();
            ob_end_clean();
        } else {
            throw new ViewException($viewfile);
        }

        /* default master */
        $hierarchy = explode("/", $this->getViewName());
        $masterviews = $viewConfig["masterview"];
        if (!is_null($masterviews[$hierarchy[0]])) {
            $settedMaster = $masterviews[$hierarchy[0]];
        }

        if (!is_null($settedMaster)) {
            $masterfile = $viewRootPath . $hierarchy[0] . "/" . $settedMaster . ".view.php";
            if (file_exists($masterfile)) {
                require_once $masterfile;
            } else {
                throw new ViewException($settedMaster);
            }
        } else {
            echo $content;
        }
    }

    public function getViewData() {
        return $this->viewData;
    }

    public function setViewData($viewData) {
        $this->viewData = $viewData;
    }

    public function getViewName() {
        return $this->viewName;
    }

    public function setViewName($viewName) {
        $this->viewName = $viewName;
    }

}

?>
