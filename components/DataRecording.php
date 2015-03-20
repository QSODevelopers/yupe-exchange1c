<?php
/**
* 
*/
class DataRecording extends CApplicationComponent
{
    public $modelAttributes = [];

    public $errors = [];

    public function setAttributes($modelName, $attribute)
    {
        $flag = true;
        foreach ($attribute as $key => $value){
            $value = trim($value);
            if ($value==="")
                $flag = false;
        }

        if ($flag)
            $this->modelAttributes[$modelName] = $attribute;
    }

    public function saveData()
    {
        if (empty($this->modelAttributes))
            return false;

        print_r($this->modelAttributes);
        // Yii::app()->end();
    }
}
?>