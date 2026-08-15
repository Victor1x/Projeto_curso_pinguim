<?php

namespace App\Models;

use Database\Factories\QuestionsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    /** @use HasFactory<QuestionsFactory> */
    use HasFactory;

    protected $table = 'tb_questions';

    protected $primaryKey = 'id';

    protected $fillable = ["questions"];

    //     protected $guarded = [];
}
