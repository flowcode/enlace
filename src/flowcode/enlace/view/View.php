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

    function __construct($viewData, $viewName = NULL, $viewLayout = "hierarchy") {
        $this->viewName = $viewName;
        $this->viewData = $viewData;
    }

    public function render() {
        $viewConfig = Enlace::get("view");
        $viewRootPath = $viewConfig["path"];
        $settedLayout = null;

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
        if ($this->viewLayout != false) {
            $hierarchy = explode("/", $this->getViewName());
            $layouts = $viewConfig["layout"];
            if (!is_null($layouts[$hierarchy[0]])) {
                $settedLayout = $layouts[$hierarchy[0]];
            }
        }

        if (!is_null($settedLayout)) {
            $layoutFile = $viewRootPath . "/" . $hierarchy[0] . "/" . $settedLayout . ".view.php";
            if (file_exists($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new ViewException($settedLayout);
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
