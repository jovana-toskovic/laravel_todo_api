<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['deadline'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lists()
    {
        return $this->belongsToMany(TodoList::class, 'lists_tasks', 'task_id')
            ->withPivot(['deadline', 'done']);
    }

    public function getDeadlineAttribute($value)
    {
        if($this->user->timezone) {
            return (new Carbon($this->pivot->deadline))->setTimezone($this->user->timezone)->format('Y-m-d H:i:s');
        }

        return $this->pivot->deadline;
    }

}
