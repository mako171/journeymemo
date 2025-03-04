<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'listpage_id'];

    public function listpage()
    {
        return $this->belongsTo(Listpage::class, 'listpage_id');
    }
}
