<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCategory extends Model
{
    protected $table            = 'productcategory';
    protected $primaryKey       = 'categoryId';
    protected $returnType       = 'object';
    protected $allowedFields    = ['categoryName', 'categorySlug'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'modifiedAt';
}
