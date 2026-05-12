<?php

namespace App\Models;

use CodeIgniter\Model;

class RessourceModel extends Model
{
    protected $table = 'ressources';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'type', 'capacite', 'description', 'created_at'];
}