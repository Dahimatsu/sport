<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCreneaux extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'ressource_id' => ['type' => 'INT', 'unsigned' => true],
            'date_debut' => ['type' => 'DATETIME'],
            'date_fin' => ['type' => 'DATETIME'],
            'places_dispo' => ['type' => 'INT', 'unsigned' => true],
            'actif' => ['type' => 'BOOLEAN', 'default' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ressource_id', 'ressources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('creneaux');
    }

    public function down()
    {
        $this->forge->dropTable('creneaux');
    }
}