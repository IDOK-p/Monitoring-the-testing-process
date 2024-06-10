<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $fillable = ['name'];

    public $timestamps = false;

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
