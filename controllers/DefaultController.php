<?php

class DefaultController extends \yupe\components\controllers\FrontController
{
	public function actionIndex()
	{
        echo '<pre>';
        $readableFile = Yii::getPathOfAlias('webroot').$this->module->folderFiles;
        $content = @file_get_contents($readableFile.'/'.$this->module->readFileProducts);

        print_r($this->module->arrayCorrespondences);

        if ($content) {

            foreach (explode("\n", $content) as $key => $row) {                            // разбитие по строке
                
                $row = trim($row, $this->module->columnSeparator."\r");
                $rowArray = explode($this->module->columnSeparator, $row);                 // разбитие строки на массив

                foreach ($this->module->arrayCorrespondences as $modelName=>$attributes) { // Разбитие на моедли
                    
                    foreach ($attributes as $key => $value) {                              // проверка атрибутов модели
                        
                        $span = preg_replace_callback("/{(\w+)}/",
                            function($matches) use ($rowArray){
                                $s = '';
                                foreach ($matches as $value) {
                                    $s .= $rowArray[$value];
                                }
                                return $s;
                            }
                        , $value);

                        switch ($key) {
                            case 'id': $span = (int)$span;
                                break;
                             case 'category_id': $span = (int)$span;
                                break;
                            case 'price': $span = (int)$span;
                                break;
                            case 'slug': $span = ConvertChars::convert($span);
                                break;
                        }
                        $attributes[$key] = $span;
                    }
                    print_r($attributes['slug']);
                    /*if (isset($attributes['id'])) {
                        $model = CActiveRecord::model($modelName)->findByPk($attributes['id']);
                    }else if(isset($attributes['name'])){
                        $model = CActiveRecord::model($modelName)->findByAttributes(['name'=>$attributes['name']]);
                    }

                    if ($model===null)
                        $model = CActiveRecord::model($modelName);

                    $model->attributes = $attributes;*/ // Сформированный массим атрибутов для определенной моедели.

                    // echo '<pre>';
                    // print_r($model->attributes);
                    // Yii::app()->end();
                    // echo '</pre>';
                    
                    /*if ($model->save()) {
                        echo 'ok<br>';
                    } else {
                        print_r($model->errors);
                        print_r($model->attributes);
                        print_r($attributes);
                    }*/
                        echo '<hr>';

                }

            }

        }
	}

    public function actionTestRead($size)
    {
        $readableFile = Yii::getPathOfAlias('webroot').$this->module->folderFiles;
        $content = @file_get_contents($readableFile.'/'.$this->module->readFileProducts);

        if ($content) {

            echo '<pre>';
            foreach (explode("\n", $content) as $key => $row) {                            // разбитие по строке
                $row = trim($row, $this->module->columnSeparator."\r");
                echo '№' . ++$key . ' ' . $row."\r";
                $rowArray = explode($this->module->columnSeparator, $row);                 // разбитие строки на массив
                print_r($rowArray);
                if ($key===(int)$size)
                    break;
            }
            echo '</pre>';
        }
    }
}