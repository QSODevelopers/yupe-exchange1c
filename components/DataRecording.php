<?php
/**
* 
*/
class DataRecording extends CApplicationComponent
{
	public $id;
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

		$attrs = $this->modelAttributes;

		$idProducer = Yii::app()->cache->get($attrs['Producer']['slug']);
		if($idProducer===false){
			$producer = new Producer;
			$producer->setAttributes($attrs['Producer']);
			if ($producer->save()) {
				$idProducer = $producer->id;
				Yii::app()->cache->set($attrs['Producer']['slug'], $idProducer);
			} else {
				$this->errors[$this->id]['Producer'] = $producer->errors;
			}

		}

		$idStoreCategory = Yii::app()->cache->get($attrs['StoreCategory']['alias']);
		if($idStoreCategory===false){
			$category = new StoreCategory;
			$category->setAttributes($attrs['StoreCategory']);
			if ($category->save()){
				$idStoreCategory = $category->id;
				Yii::app()->cache->set($attrs['StoreCategory']['alias'], $idStoreCategory);
			} else {
				$this->errors[$this->id]['StoreCategory'] = $category->errors;
			}

		}

		$product = new Product;
		$attrs["Product"]['producer_id'] = $idProducer;
		$attrs["Product"]['category_id'] = $idStoreCategory;
		$product->setAttributes($attrs['Product']);
		if ($product->save())
			$this->errors[$this->id]['Product'] = $product->errors;
	}
}
?>