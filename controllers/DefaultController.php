<?php

class DefaultController extends \yupe\components\controllers\FrontController
{
	public function actionIndex()
	{
        echo '<pre>';
        $readableFile = Yii::getPathOfAlias('webroot').$this->module->folderFiles;
        $content = @file_get_contents($readableFile.'/'.$this->module->readFileProducts);

        $errors = [];

        // print_r($this->module->arrayCorrespondences);

        if ($content) {

            foreach (explode("\n", $content) as $id => $string) {                            // разбитие по строке

                // $record = new DataRecording($id, $string);
                $record = new DataRecording;
                $record->startLine(++$id, $string);
                
                print_r($record);
                Yii::app()->end();
            }

        }
        // print_r($errors);
        // $this->render('index');
	}

    /**/

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

    public function actionTest()
    {
        if (empty(['name'=>'', 'test'=>'']))
        {
            echo 'empty';
        }
    }

}