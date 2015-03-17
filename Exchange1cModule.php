<?php
use yupe\components\WebModule;

class Exchange1cModule extends WebModule
{
	public $folderFiles          = '/uploads/files/prices';
	public $readFileProducts     = 'goods.csv';
	public $readFileCategory     = 'category.csv';
	public $columnSeparator      = ';';
	public $arrayCorrespondences = [
		'Product'=>[
			'id'               => '{2}',  // ID
			'category_id'      => '{0}',  // Category
			// 'type_id'          => '',  // Type
			// 'name'             => '',  // Title
			// 'price'            => '',  // Price
			// 'discount_price'   => '',  // Discount price
			// 'discount'         => '',  // Discount, %
			// 'sku'              => '',  // SKU
			'image'            => '{2}',  // Image
			'short_description'=> 'Артикул: {5}; {4}',  // Short description
			// 'description'      => '',  // Description
			// 'alias'            => '',  // Alias
			// 'data'             => '',  // Data
			// 'status'           => '',  // Status
			// 'create_time'      => '',  // Added
			// 'update_time'      => '',  // Updated
			// 'user_id'          => '',  // User
			// 'change_user_id'   => '',  // Editor
			// 'is_special'       => '',  // Special
			// 'length'           => '',  // Length, m.
			// 'height'           => '',  // Height, m.
			// 'width'            => '',  // Width, m.
			// 'weight'           => '',  // Weight, kg.
			// 'quantity'         => '',  // Quantity
			// 'producer_id'      => '',  // Producer
			// 'in_stock'         => '',  // Stock status
			// 'category'         => '',  // Category
			// 'meta_title'       => '',  // Meta title
			// 'meta_keywords'    => '',  // Meta keywords
			// 'meta_description' => '',  // Meta description
			// 'purchase_price'   => '',  // Purchase price
			// 'average_price'    => '',  // Average price
			// 'recommended_price'=> '',  // Recommended price
			// 'position'         => '',  // Position
		],
		'StoreCategory'=>[
			'id'               => '{0}',  // Id
			// 'parent_id'        => '',  // Родитель
			'name'             => '{1}',  // Название
			// 'image'            => '',  // Изображение
			// 'short_description'=> '',  // Краткое описание
			// 'description'      => '',  // Полное описание
			// 'alias'            => '',  // Alias
			// 'meta_title'       => '',  // Meta title
			// 'meta_keywords'    => '',  // Meta keywords
			// 'meta_description' => '',  // Meta description
			// 'status'           => '',  // Статус
			// 'sort'             => '',  // Порядок сортировки
		],
		'Producer'=>[
			// 'id'                => '',  // ID
            'name_short'        => '{6}',  // Short title
            'name'              => '{6}',  // Title
            // 'slug'              => '',  // URL
            // 'status'            => '',  // Status
            // 'order'             => '',  // Order
            // 'image'             => '',  // Image
            // 'short_description' => '',  // Short description
            // 'description'       => '',  // Description
            // 'meta_title'        => '',  // Meta title
            // 'meta_keywords'     => '',  // Meta keywords
            // 'meta_description'  => '',  // Meta description
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
