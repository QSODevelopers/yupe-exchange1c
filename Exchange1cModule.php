<?php
use yupe\components\WebModule;

class Exchange1cModule extends WebModule
{
	public $folderFiles          = '/uploads/files/prices';
	public $readFileProducts     = 'goods.csv';
	public $readFileCategory     = 'category.csv';
	public $columnSeparator      = ';';
	public $arrayCorrespondences = [
		'Producer'=> [
			// 'id'                => '',
            'id_1c'             => '{6}',
            'name_short'        => '{7:string}',
            'name'              => '{7}',
            'slug'              => '{7}',
            'status'            => '1',
		],
		'StoreCategory' => [
			'id_1c'             => '{0:int}',
			'name'              => '{1}',
			'alias'             => '{1}',
			'status'            => '1',
			'sort'              => '{0:int}',
		],
		'Product' => [
			'id_1c'             => '{2:int}',
			'category_id'       => '{0:int}',
			'name'              => '{3}',
			'quantity'          => '{11}',
			'image'             => '{2:int}.{12}',
			'status'            => '1',
			'is_special'        => '0',
			'in_stock'          => '1',
			'price'             => '{10:int}',
			'short_description' => 'Артикул: {5}; Производитель: {7} {4}',
			'description'       => '{13}',
            'slug'              => '{3}',  // URL
		]
	];

	const VERSION = '0.1';

	public function getVersion()
	{
		return self::VERSION;
	}

	 public function getDependencies()
	{
		return [
			'store',
		];
	}

	/*public function getCategory()
	{
		return Yii::t('Exchange1cModule.main', 'Catalog');
	}*/

	public function getName()
	{
		return Yii::t('Exchange1cModule.main', 'Exchange 1c');
	}

	public function getDescription()
	{
		return Yii::t('Exchange1cModule.main', 'The module updates the database of the store unloaded files 1c');
	}

	public function getAuthor()
	{
		return Yii::t('Exchange1cModule.main', 'UnnamedTeam');
	}

	public function getAuthorEmail()
	{
		return Yii::t('Exchange1cModule.main', 'max100491@mail.ru');
	}

	public function getIcon()
	{
		return "glyphicon glyphicon-sort";
	}

	public function getNavigation()
	{
		return [
			[
				'label' => Yii::t('Exchange1cModule.main', 'Справка'),
				'url'   => ['/backend/exchange1c/exchange/help'],
				'icon'  => "fa fa-fw fa-question-circle",
			]
		];
	}

	public function checkSelf()
	{
		$messages = [];

		$readableFile = Yii::getPathOfAlias('webroot');
		$readableFile = $readableFile.$this->folderFiles;

		$readFileProducts = $readableFile.'/'.$this->readFileProducts;
		$readFileCategory = $readableFile.'/'.$this->readFileCategory;

		if (!file_exists($readableFile)) {
			$messages[WebModule::CHECK_ERROR][] = [
				'type'    => WebModule::CHECK_ERROR,
				'message' => 'Директория '.$readableFile.' не существует'
			];
		}
		
		if (!file_exists($readFileProducts)) {
			$messages[WebModule::CHECK_ERROR][] = [
				'type'    => WebModule::CHECK_ERROR,
				'message' => 'Файл '.$readFileProducts.' не существует'
			];
		}

		if (!file_exists($readFileCategory)) {
			$messages[WebModule::CHECK_ERROR][] = [
				'type'    => WebModule::CHECK_NOTICE,
				'message' => 'Файл '.$readFileCategory.' не существует'
			];
		}

		return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
	}

	public function getEditableParams()
	{
		return [
			'folderFiles',
			'readFileProducts',
			'readFileCategory',
			'columnSeparator',
		];
	}

	public function getParamsLabels()
	{
		return [
			'folderFiles'     =>'Папка файлов выгрузки',
			'readFileProducts'=>'Файл с выгруженными товарами',
			'readFileCategory'=>'Файл с выгруженными категориями',
			'columnSeparator' =>'Разделитель колонок',
		];
	}
	
	public function init()
	{
		$this->setImport(array(
			'exchange1c.models.*',
			'exchange1c.components.*',
		));
		
		parent::init();
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
