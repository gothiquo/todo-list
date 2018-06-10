<?php

namespace TaskManagement\Task\Model;

use Illuminate\Database\Eloquent\Model;
use TaskManagement\User\Model\User;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['title', 'user_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function isDone()
    {
        return (bool) $this->isDone();
    }

    public function getUser()
    {
        return $this->user;
    }
}
