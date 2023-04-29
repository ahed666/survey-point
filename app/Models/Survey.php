<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $type="surveys";
    protected $fillable = [
        'survey_name',
        'business_name',
        'comment',
        'contact_number',
        'user_id',
        'logo_id',
        'customer_info',


    ];

}
