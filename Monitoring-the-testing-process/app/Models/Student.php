<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = ['name', 'patronymic', 'surname', 'email', 'city_id', 'school_id', 'class_id'];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
