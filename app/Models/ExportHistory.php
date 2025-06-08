<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportHistory extends Model
{
    protected $table = 'export_histories';

    protected $fillable = [
        'id_user',
        'export_type',
        'file_name',
        'filter'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
