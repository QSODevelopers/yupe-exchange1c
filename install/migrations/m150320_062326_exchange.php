<?php

class m150320_062326_exchange extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('{{store_category}}', 'id_1c', 'integer NOT NULL');
		// $this->createInde('ix_{{store_category}}_id_1c', '{{store_category}}', 'id_1c' false);

		$this->addColumn('{{store_producer}}', 'id_1c', 'integer NOT NULL');
		// $this->createInde('ix_{{store_producer}}_id_1c', '{{store_producer}}', 'id_1c' false);

		$this->addColumn('{{store_product}}', 'id_1c', 'integer NOT NULL');
		// $this->createInde('ix_{{store_product}}_id_1c', '{{store_product}}', 'id_1c' false);

	}

	public function safeDown()
	{
		// $this->createInde('ix_{{store_category}}_id_1c', '{{store_category}}');
		$this->dropColumn('{{store_category}}', 'id_1c');

		// $this->createInde('ix_{{store_producer}}_id_1c', '{{store_producer}}');
		$this->dropColumn('{{store_producer}}', 'id_1c');

		// $this->createInde('ix_{{store_product}}_id_1c', '{{store_product}}');
		$this->dropColumn('{{store_product}}', 'id_1c');

	}
	
}