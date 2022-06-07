<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'lists_tasks', 'list_id')
            ->withPivot(['deadline', 'done']);
    }
}
