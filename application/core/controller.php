<?php

/*
    Базовый класс контроллеров.
    Потомки должны включать в себя методы вида:
    function action_actionName( $args ) кторые будут вызваны объктом запроса.
    $args - массив аргументов.

    Конкретный контроллер должен создать требуемую модель,
    требуемый вид и добавить его (созданный им вид) в
    определенный плейс-ходер (главного вида).
*/

class TController {

    protected function createModel( $modelName, $args = null ){
        $modelPath = "application/models/".$modelName.".php";
        $modelPath = mb_strtolower( $modelPath );

        if( file_exists($modelPath) )
            include_once($modelPath);
        else
            return null;

        $modelClass = "Model".$modelName;
        if ($args === null)
            $model = new $modelClass();
        else
            $model = new $modelClass( $args );

        return $model;
    }
}

?>