<?php

namespace App\Models;

use CodeIgniter\Model;

class PlannerModel extends Model
{
    protected $table = 'planner_events';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'reminder_at',
        'is_completed'
    ];

    protected $useTimestamps = true;
}