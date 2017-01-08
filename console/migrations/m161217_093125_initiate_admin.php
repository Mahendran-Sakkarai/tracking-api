<?php

use yii\db\Migration;

class m161217_093125_initiate_admin extends Migration
{
    public function up()
    {
        $db = $this->db;
        $db->createCommand()->insert("user",[
            "first_name" => "Initial",
            "last_name" => "Admin",
            "dob" => "1991-01-01",
            "username" => "admin",
            "mobile_no" => "9876543210",
            "gender" => "2",
            "timezone" => "Asia/Kolkatta",
            "access_token" => "1HJn4FXEWV8HJWJeJwWkELdddmwxOy8CS1SukM6hbzOXUSx",
            "auth_key" => "Txuv0bwTpllU-Mg2YquPUke0_X6rM6zs",
            "password_hash" => '$2y$13$OqdcYXTyYTYmkZlDiogXk.lfTOEKtjJSoNAQHXdnZ8wND201lNGPe',// Initial password is Admin@appslabz123
            "status" => "10",
            "created_at" => microtime(true) * 1000,
            "updated_at" => microtime(true) * 1000
        ])->execute();

        $this->insert("auth_assignment",[
            "item_name" => "admin",
            "user_id" => $db->getLastInsertID(),
            "created_at" => microtime(true)
        ]);
    }

    public function down()
    {
        echo "m160826_064912_initiate_admin cannot be reverted.\n";

        return false;
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
