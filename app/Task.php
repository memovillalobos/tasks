<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['type', 'task', 'responsible', 'estimate', 'status', 'version', 'platform', 'task_id'];
}
