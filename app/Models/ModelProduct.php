<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduct extends Model
{
    protected $table            = 'product';
    protected $primaryKey       = 'ProductId';
    protected $returnType       = 'object';
    protected $allowedFields    = ['productSlug', 'categorySlug', 'productName', 'description', 'productImage'];

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
