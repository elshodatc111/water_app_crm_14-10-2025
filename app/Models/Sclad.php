<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sclad extends Model{

    use HasFactory;

    protected $table = 'sclads';

    protected $fillable = [
        'tayyor',
        'yarim_tayyor',
        'nosoz',
        'balans_naqt',
        'balans_plastik',
    ];

    public function histories(){
        return $this->hasMany(ScladHistory::class, 'sclad_id');
    }
}
