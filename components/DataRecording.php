<?php
class DataRecording extends CApplicationComponent
{
	/**
	 * @var string обрабатываемая строка
	 */
	private $string;

	/**
	 * @var string переключатель модели
	 */
	private $model;

	/**
	 * @var string переключатель атрибута
	 */
	private $attribute;

	/**
	 * @var array преобразованная строка $string
	 */
	public $arrayData;

	/**
	 * @var integer номер строки
	 */
	public $id;

	/**
	 * @var array модели и атрибуты
	 */
	public $modelsAttributes = [];

	/**
	 * @var array Ошибки валидации
	 */
	public $errors = [];

	/**
	 * Устанавливает свойства
	 * @param integer $id номер строки из файла
	 * @param string $string обрабатываемая строка
	 */
	public function startLine($id, $string)
	{
		$this->string = $string;
		$this->id = $id;
		$this->processLine();
		$this->distributeModels();
	}

	/**
	 * Преобразовывает строку данных в массив, устанавлевает его как свойство
	 */
	private function processLine()
	{
		$string = trim($this->string);
		$this->arrayData = explode(Yii::app()->getModule('exchange1c')->columnSeparator, $string);
	}

	/**
	 * Устанавлевает свойство массив моделей
	 */
	public function distributeModels()
	{
		foreach (Yii::app()->getModule('exchange1c')->arrayCorrespondences as $modelName=>$tmpAttr) {
			$this->model = $modelName;
			$this->fillTemplateAttributes($tmpAttr);
		}
		$this->saveData();
	}

	/**
	 * Обрабатывает массив аттрибутов и шаблонов одной модели.
	 * Преобразует шаблон
	 * Устанавливает атрибут и значение включенной модели
	 * @param array $tmpAttr ключ элемента массива атрибут модели, значение шаблон этого атрибута.
	 */
	public function fillTemplateAttributes($tmpAttr)
	{
		foreach ($tmpAttr as $attr => $tmp) {
			$this->attribute = $attr;
			$span = preg_replace_callback("/{[\d]+[:\w]*}/", [$this, 'convertToType'], $tmp);
			$this->modelsAttributes[$this->model][$attr] = $span;
		}
	}

	/**
	 * Транслит строки
	 * @param string $str необработанная строка
	 * @return string строка в транслите
	 */
	public function convert($str)
	{
		$tr = [
			"А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d", "Е"=>"e", "Ё"=>"e",
			"Ж"=>"j", "З"=>"z", "И"=>"i", "Й"=>"y", "К"=>"k", "Л"=>"l", "М"=>"m",
			"Н"=>"n", "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t", "У"=>"u",
			"Ф"=>"f", "Х"=>"h", "Ц"=>"ts", "Ч"=>"ch", "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"",
			"Ы"=>"i", "Ь"=>"j", "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b",
			"в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"e", "ж"=>"j", "з"=>"z",
			"и"=>"i", "й"=>"y", "к"=>"k", "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o",
			"п"=>"p", "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", "х"=>"h",
			"ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", "ъ"=>"y", "ы"=>"i", "ь"=>"j",
			"э"=>"e", "ю"=>"yu", "я"=>"ya", " "=> "-", "."=> "", "/"=> "-", ","=>"-",
			"-"=>"-", "("=>"", ")"=>"", "["=>"", "]"=>"", "="=>"-", "+"=>"-",
			"*"=>"", "?"=>"", "\""=>"", "'"=>"", "&"=>"", "%"=>"", "#"=>"", "@"=>"",
			"!"=>"", ";"=>"", "№"=>"", "^"=>"", ":"=>"", "~"=>"", "\\"=>""
		];
		return strtr($str,$tr);
	}

	/**
	 * Обрабатывает элемент шаблона
	 * Транслит строки в зависимости от включенного атрибута
	 * @param array $val массив с вхождениями,
	 * значение элемента массива {n} где n integer - ключ для выборки из свойства arrayData
	 * @return mixed данные из свойства arrayData
	 */
	public function convertToType($val)
	{
		$val = $val[0];
		$elem = explode(':', trim($val,'{}'));
		$result = $this->arrayData[current($elem)];

		if($this->attribute=='slug' or $this->attribute=='alias') {
			$result = $this->convert($result);
		}

		if (count($elem) <= 1)
			return $result; // без преобразования типа

		else{
			// нужно преобразовать
			settype($result, $elem[1]);
			return $result;
		}
	}

	public function saveData()
	{
		$attrs = $this->modelsAttributes;

		$idProducer = Yii::app()->cache->get($attrs['Producer']['slug']); // нужно проверить заполнина ли модель насоклько что бы произошло сохранение
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