<?php

class Exchange1cModule extends yupe\components\WebModule
{
	const VERSION = '0.1';

	 public function getDependencies()
	{
		return [
			'store',
		];
	}

    public function getName()
    {
        return Yii::t('Exchange1cModule.default', 'Exchange1c');
    }

	public function getDescription()
	{
		return Yii::t('Exchange1cModule.default', 'The module updates the database of the store unloaded files 1c');
	}

	public function getAuthor()
    {
        return Yii::t('StoreModule.store', 'UnnamedTeam');
    }

	public function getAuthorEmail()
	{
		return Yii::t('Exchange1cModule.default', 'max100491@mail.ru');
	}

	public function getIcon()
	{
		return "fa fa-fw fa-heart";
	}

	public function getVersion()
	{
		return self::VERSION;
	}
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'exchange1c.models.*',
			'exchange1c.components.*',
		));
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
