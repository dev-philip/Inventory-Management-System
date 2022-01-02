<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $table = 'playlist';
    protected $fillable = [
        'playlist',
        'title',
        'artist',
        'songurl',
        'poster',
        'key',
        'date',
        'time',
    ];
}
