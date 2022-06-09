<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ListTask extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'lists_tasks';


    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function getDeadlineAttribute($value)
    {
        if($timezone = $this->task->user->timezone) {
            return (new Carbon($value))->setTimezone($timezone)->format('Y-m-d H:i:s');
        }

        return $value;
    }

    public function getDoneAttribute($value)
    {
        if($timezone = $this->task->user->timezone) {
            return (new Carbon($value))->setTimezone($timezone)->format('Y-m-d H:i:s');
        }

        return $value;
    }
}
