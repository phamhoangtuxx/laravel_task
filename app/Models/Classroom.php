<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Classroom extends Model
{
    use HasFactory;

    protected $table = 'class_room';
    public $primaryKey = 'classroomID';
    public $incrementing = false;
}
