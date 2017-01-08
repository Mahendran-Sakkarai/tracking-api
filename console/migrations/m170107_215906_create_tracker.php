<?php

use yii\db\Migration;

class m170107_215906_create_tracker extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%tracker}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
            'client_id' => $this->string(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-tracker-user_id',
            'tracker',
            'user_id'
        );
        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-tracker-user_id',
            'tracker',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        echo "m170107_215906_create_tracker cannot be reverted.\n";
        $this->dropTable("tracker");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
