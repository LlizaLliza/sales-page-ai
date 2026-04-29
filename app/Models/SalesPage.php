<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPage extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'features',
        'target_audience',
        'price',
        'selling_points',
        'generated_html',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
