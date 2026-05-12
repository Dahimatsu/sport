<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {
        // 1. Créer un administrateur de test
        $user = [
            'nom' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
        ];
        $this->db->table('users')->insert($user);

        // 2. Créer quelques ressources (salle et terrain)
        $ressources = [
            [
                'nom' => 'Salle de Yoga',
                'type' => 'salle',
                'capacite' => 20,
                'description' => 'Salle spacieuse pour les cours collectifs.',
            ],
            [
                'nom' => 'Terrain de Tennis 1',
                'type' => 'terrain',
                'capacite' => 4,
                'description' => 'Terrain extérieur en dur.',
            ]
        ];
        $this->db->table('ressources')->insertBatch($ressources);

        // 3. Créer quelques créneaux pour ces ressources (pour demain)
        $creneaux = [
            [
                'ressource_id' => 1, // Correspond à la Salle de Yoga
                'date_debut' => date('Y-m-d 10:00:00', strtotime('+1 day')),
                'date_fin' => date('Y-m-d 11:30:00', strtotime('+1 day')),
                'places_dispo' => 20,
                'actif' => 1,
            ],
            [
                'ressource_id' => 2, // Correspond au Terrain de Tennis
                'date_debut' => date('Y-m-d 14:00:00', strtotime('+1 day')),
                'date_fin' => date('Y-m-d 15:00:00', strtotime('+1 day')),
                'places_dispo' => 4,
                'actif' => 1,
            ]
        ];
        $this->db->table('creneaux')->insertBatch($creneaux);
    }
}