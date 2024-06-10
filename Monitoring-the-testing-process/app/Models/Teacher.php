<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $fillable = ['name', 'patronymic', 'surname', 'email', 'password', 'city_id', 'school_id'];

    // Определяем скрытые поля (обычно пароли и remember tokens)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Определяем приведение типов для полей
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
