<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'posistion_history_id', 'taxonomy_name', 'category_code', 
        'comments'
    ];
    public function posistionHistories()
    {
        return $this->belongsTo(PosistionHistory::class);
    }

}
