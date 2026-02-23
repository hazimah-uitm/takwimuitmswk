<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'created_by',
        'nama_program',
        'mula_at',
        'tamat_at',
        'lokasi',
        'penganjur',
        'peringkat',
        'agensi_terlibat',
        'pegawai_rujukan',
        'pautan',
        'catatan',
    ];

    protected $dates = [
        'mula_at',
        'tamat_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function attachments()
    {
        return $this->hasMany(EventAttachment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
