<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Listpage extends Model
{
    use HasFactory;
    protected $fillable = [
        'list_log', 'prefecture_id', 'category_id', 'title', 'body', 'user_id'
    ];

    public static $rules = [
        'list_log' => 'required|integer',
        'prefecture_id' => 'required|exists:prefectures,id',
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'body' => 'nullable|string',
        'images' => 'array',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像バリデーション
    ];

    // 都道府県とのリレーション
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    // カテゴリとのリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 画像とのリレーション
    public function images()
    {
        return $this->hasMany(Image::class, 'listpage_id');
    }
}
