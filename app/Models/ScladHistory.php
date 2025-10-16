<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ScladHistory extends Model{
    use HasFactory;
    protected $table = 'sclad_histories';
    protected $fillable = [
        'omborchi_id',
        'user_id',
        'type',
        'status',
        'tayyor',
        'yarim_tayyor',
        'nosoz',
        'sotildi',
        'summa_naqt',
        'summa_plastik',
        'comment',
    ];
    public function omborchi(){
        return $this->belongsTo(User::class, 'omborchi_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
