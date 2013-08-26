<?php

namespace flowcode\enlace\view;


/**
 * Description of View
 *
 * @author juanma
 */
class PlainView implements IView {

    protected $viewData;

    function __construct($viewData) {
        $this->viewData = $viewData;
    }

    public function render() {
        echo $this->viewData["data"];
    }

}

?>
