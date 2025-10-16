<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScladTarix extends Model{
    use HasFactory;

    protected $table = 'sclad_tarixes';

    protected $fillable = [
        'idishlar',
        'nosoz_idish',
        'user_id',
        'status',
        'comment'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
