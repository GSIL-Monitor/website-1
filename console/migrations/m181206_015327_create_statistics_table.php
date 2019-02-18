<?php

use yii\db\Migration;

/**
 * Handles the creation for table `statistics_table`.
 */
class m181206_015327_create_statistics_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('statistics_table', [
            'id' => $this->primaryKey(),
            'ip' => $this->string('20')->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('statistics_table');
    }
}
