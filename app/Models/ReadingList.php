<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model ReadingList
class ReadingList extends Model
{
    use HasFactory;

    protected $table = 'reading_list';

    protected $fillable = ['user_id', 'comic_id', 'status'];
}