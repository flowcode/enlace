<?php

namespace flowcode\wing\mvc\view;

use flowcode\wing\mvc\config\Config;
use flowcode\wing\mvc\exception\ViewException;
use HTMLPurifier;
use HTMLPurifier_Config;

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
        $settedLayout = null;

        /* set view data available */
        $viewData = $this->viewData;

        $content = "";
        /* with master */
        $viewfile = $viewRootPath . "/" . $this->getViewName() . ".view.php";
        if (file_exists($viewfile)) {
            ob_start();
            require_once $viewfile;
            $content .= ob_get_contents();
            ob_end_clean();
        } else {
            throw new ViewException($viewfile);
        }

        /* default master */
        $hierarchy = explode("/", $this->getViewName());
        $layouts = $viewConfig["layout"];
        if (!is_null($layouts[$hierarchy[0]])) {
            $settedLayout = $layouts[$hierarchy[0]];
        }

        if (!is_null($settedLayout)) {
            $layoutFile = $viewRootPath . "/" . $hierarchy[0] . "/" . $settedLayout . ".view.php";
            if (file_exists($layoutFile)) {
                ob_start();
                require_once $layoutFile;
                $content .= ob_get_contents();
                ob_end_clean();
            } else {
                throw new ViewException($settedLayout);
            }
        }

        /* content cleaning */
        $htmlPurifierConfig = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($htmlPurifierConfig);
        $cleanContent = $purifier->purify($content);

        /* render clean content */
        echo $cleanContent;
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
