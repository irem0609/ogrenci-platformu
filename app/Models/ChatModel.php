<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat_messages';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'role',
        'message'
    ];

    protected $useTimestamps = false;
}