<?php

namespace flowcode\enlace\view;

/**
 * Description of View
 *
 * @author juanma
 */
class JsonView implements IView {

    protected $viewData;

    function __construct($viewData) {
        $this->viewData = $viewData;
    }

    public function render() {
        header('Content-type: application/json');
        echo $this->toJson($this->viewData["data"]);
    }

    /**
     * Retorna la representacion json del objecto recibido por parametro.
     * @param type $object
     * @return json json. 
     */
    private function toJson($object) {
        $array = $this->toArray($object);
        return str_replace('\\u0000', "", json_encode($array));
    }

    /**
     * Convierte un objeto a notacion json.
     * @param type $obj
     * @return type 
     */
    private function toArray($obj) {
        $arr = array();

        if (is_array($obj)) {
            foreach ($obj as $value) {
                $arr[] = $this->toArray($value);
            }
        } else if (is_object($obj)) {
            $arObj = (array) $obj;
            foreach ($arObj as $key => $value) {
                $attribute = str_replace(get_class($obj), "", $key);
                if (is_object($value) || is_array($value)) {
                    $value = $this->toArray($value);
                } else {
                    $arr[$attribute] = $this->utf8_encode_all($value);
                }
            }
        } else {
            $arr = $this->utf8_encode_all($obj);
        }
        return $arr;
    }

    private function utf8_encode_all($dat) {
        if (is_string($dat)) {
            return utf8_encode($dat);
        }
        if (!is_array($dat)) {
            return $dat;
        }
        $ret = array();
        foreach ($dat as $i => $d) {
            $ret[$i] = $this->utf8_encode_all($d);
        }
        return $ret;
    }

}

?>
