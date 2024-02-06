<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function title(){
        return $this->belongsTo(Title::class,"title", 'id');
    }

    /*protected $fillable = [
        'title' ,
        'family_name',
        'name',
        'birthday' ,
        'age',
        'gender' ,
        'address' ,
        'mobile',
        'email',
        'height_feets' ,
        'height_inches' ,
        'height_cen' ,
        'weight',
        'nic' ,
        'occupation',
        'status',
        'fingerprint_id',
        'finger2',
        'finger3',
        'finger4',
        'finger5',
    ];*/
}

