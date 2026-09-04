<?php

namespace App\Models;

use CodeIgniter\Model;

class ImportantReminderModel extends Model
{
    protected $table = 'important_reminders';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'title',
        'is_completed'
    ];

    protected $useTimestamps = true;
}