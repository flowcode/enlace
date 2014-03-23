<?php

namespace flowcode\enlace\view;

use flowcode\enlace\Enlace;
use flowcode\enlace\exception\ViewException;
use flowcode\enlace\view\IView;

/**
 * Description of View
 *
 * @author juanma
 */
class View implements IView {

    protected $viewData;
    protected $viewName;
    protected $viewLayout;

    function __construct($viewData, $viewName, $viewLayout = "hierarchy") {
        $this->viewName = $viewName;
        $this->viewData = $viewData;
        $this->viewLayout = $viewLayout;
    }

    public function render() {
        $viewConfig = Enlace::get("view");
        $viewRootPath = $viewConfig["path"];
        $settedLayout = null;

        /* set view data available */
        $viewData = $this->viewData;

        if ($this->viewLayout != false) {

            $hierarchy = explode("/", $this->getViewName());
            $levelsCount = count($hierarchy) - 2;

            /* include view */
            $viewfile = $viewRootPath . "/" . $this->getViewName() . ".view.php";
            if (file_exists($viewfile)) {
                ob_start();
                require $viewfile;
                $content[$hierarchy[$levelsCount]] = ob_get_contents();
                ob_end_clean();
            } else {
                throw new ViewException($viewfile);
            }

            /* hierarchy include layouts */
            for ($level = $levelsCount; $level >= 0; $level--) {
                $layoutName = $hierarchy[$level];
                if ($level > 0) {
                    /* if not root level */
                    $viewfile = $viewRootPath;
                    for ($m = 0; $m <= $level; $m++) {
                        $viewfile .= "/" . $hierarchy[$m];
                    }
                    $viewfile .= "/" . $layoutName . ".view.php";
                    if (file_exists($viewfile)) {
                        ob_start();
                        require $viewfile;
                        $content[$hierarchy[$level - 1]] = ob_get_contents();
                        ob_end_clean();
                    } else {
                        throw new ViewException($viewfile);
                    }
                } else {
                    /* root layout */
                    $layoutFile = $viewRootPath . "/" . $layoutName . "/" . $layoutName . ".view.php";
                    if (file_exists($layoutFile)) {
                        require $layoutFile;
                    } else {
                        throw new ViewException($layoutName);
                    }
                }
            }
        } else {
            /* without master */
            $viewfile = $viewRootPath . "/" . $this->getViewName() . ".view.php";
            if (file_exists($viewfile)) {
                require $viewfile;
            } else {
                throw new ViewException($viewfile);
            }
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