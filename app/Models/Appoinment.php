<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    use HasFactory;
    protected $guarded=[
        // 'appointment_no',
        // 'patient_id',
        // 'patient name',
        // 'finger_print',
        // 'date',
        // 'status',
        // 'appdate time',
        // 'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts =[
        'appointment_no'=>'integer',
        'patient_id'=>'integer',
        'date'=>'date',
        'status'=>'boolean',
        'active'=>'boolean',
        'appdate_time'=>'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    // protected $attributes = [
    //     'status' => false,
    //     'active' => false,
    //     'appdate_time' => date('Y-m-d H:i:s'),
    // ];

    public function patients(){
        return $this->belongsTo(Patients::class);
    }

}
