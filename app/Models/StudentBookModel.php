<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentBookModel extends Model
{
    protected $table = 'student_books';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'book_id',
        'current_page',
        'status',
        'is_favorite',
        'rating',
        'review',
        'started_at',
        'finished_at'
    ];

    protected $useTimestamps = true;
}