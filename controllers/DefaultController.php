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

            foreach (explode("\n", $content) as $key => $row) {
                $rowArray = explode($this->module->columnSeparator, $row);
                foreach ($this->module->arrayCorrespondences as $modelName=>$attributes) {
                    foreach ($attributes as $key => $value) {
                        $str = preg_replace_callback("/{(\w+)}/",
                            function($matches){
                                $string = '';
                                foreach ($matches as $key => $value) {
                                    $string .= $row;
                                }
                                return $string[1];
                            }
                        ,$value);

                        print_r($str);
                        echo '<br>';
                    }
                }
                /*
                    print_r($rowArray);
                echo '</pre>';*/
            }

        }
	}
}