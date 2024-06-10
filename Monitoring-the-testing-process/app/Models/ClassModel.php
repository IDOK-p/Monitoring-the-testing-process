<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ClassModel extends Model
    {
        use HasFactory;

        // Укажите таблицу, связанную с моделью
        protected $table = 'classes';

        // Укажите поля, которые можно массово заполнять
        protected $fillable = ['name'];

        public $timestamps = false;

        public function students()
        {
            return $this->hasMany(Student::class, 'class_id');
        }

    }
