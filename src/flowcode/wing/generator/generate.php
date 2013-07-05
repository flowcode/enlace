<?php

require('../kernel/Autoloader.class.php');

if (count($argv) < 2) {
    fwrite(STDOUT, "Ingrese el nombre de la entidad, ejemplo: noticia \n");
    die();
}

$clase = $argv[1];

$entidadNombreCompleto = "\\flowcode\\inter\\domain\\" . ucfirst($clase);
$objeto = new $entidadNombreCompleto();

$classNameLength = strlen(get_class($objeto));
$array = (array) $objeto;

// dao
$fp = fopen("../../inter/dao/" . ucfirst($clase) . "Dao.class.php", "w+");
if ($fp == false) {
    die("No se ha podido crear el archivo.");
}

// inicializar el archivo y la clase
$inicializar = '<?php' . "\n";
$inicializar .= 'namespace flowcode\inter\dao;' . "\n";
$inicializar .= 'use flowcode\mvc\kernel\DataSource;' . "\n";
$inicializar .= 'use flowcode\inter\domain\\' . ucfirst($clase) . ';' . "\n";
$inicializar .= 'class ' . ucfirst($clase) . 'Dao {' . "\n";
$inicializar .= ' private $dataSource;' . "\n";
$inicializar .= '    public function __construct() {' . "\n";
$inicializar .= '        $this->dataSource = new DataSource();' . "\n";
$inicializar .= '    }' . "\n";
fwrite($fp, $inicializar);


// Obtener por id
$obtenerPorId = 'function obtener' . ucfirst($clase) . 'PorId($id) {' . "\n";
$obtenerPorId .= 'try {' . "\n";
$obtenerPorId .= '    $query = "SELECT * FROM ' . $clase . ' ";' . "\n";
$obtenerPorId .= '    $query .= "WHERE id = $id ";' . "\n";
$obtenerPorId .= '   $' . $clase . ' = null;' . "\n";
$obtenerPorId .= '$lista = $this->dataSource->executeQuery($query);' . "\n";
$obtenerPorId .= 'if ($lista) {';
$obtenerPorId .= '$' . $clase . ' = new ' . ucfirst($clase) . '();' . "\n";
foreach ($array as $key => $value) {
    $atributo = trim(substr($key, $classNameLength + 1));
    $obtenerPorId .= '                $' . $clase . '->set' . ucfirst($atributo) . '($lista[0]["' . $atributo . '"]);' . "\n";
}
$obtenerPorId .= '            }' . "\n";
$obtenerPorId .= '            return $' . $clase . ';' . "\n";
$obtenerPorId .= '        } catch (\Exception $pEx) {' . "\n";
$obtenerPorId .= '            throw new EntityDaoException("No se pude obtener la entidad en funcion del id.  SQLError: " . $pEx->getMessage());' . "\n";
$obtenerPorId .= '        }' . "\n";
$obtenerPorId .= '    }' . "\n";
fwrite($fp, $obtenerPorId);


// Obtener entidades todas
$obtenerTodas = 'function obtener' . ucfirst($clase) . 's() {' . "\n";
$obtenerTodas .= '        try {' . "\n";
$obtenerTodas .= '            $query = "SELECT * FROM ' . $clase . ' ";' . "\n";
$obtenerTodas .= '            $lista = $this->dataSource->executeQuery($query);' . "\n";
$obtenerTodas .= '            if ($lista) {' . "\n";
$obtenerTodas .= '                foreach ($lista as $fila) {' . "\n";
$obtenerTodas .= '                    $' . $clase . ' = new ' . ucfirst($clase) . '();' . "\n";
foreach ($array as $key => $value) {
    $atributo = trim(substr($key, $classNameLength + 1));
    $obtenerTodas .= '                $' . $clase . '->set' . ucfirst($atributo) . '($lista["' . $atributo . '"]);' . "\n";
}
$obtenerTodas .= '                }' . "\n";
$obtenerTodas .= '            }' . "\n";
$obtenerTodas .= '        } catch (\Exception $pEx) {' . "\n";
$obtenerTodas .= '            throw new EntityDaoException("No se pude obtener las entidades.  SQLError: " . $pEx->getMessage());' . "\n";
$obtenerTodas .= '        }' . "\n";
$obtenerTodas .= '    }' . "\n";
fwrite($fp, $obtenerTodas);


// Fin del archivo
$finalizar = "}";
fwrite($fp, $finalizar);


fclose($fp);
?>
