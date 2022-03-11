<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid',
        'birth_date',
        'ctzn',
        'per_adr',
        'tin',
        'pport_issue_place',
        'sur_name',
        'gd',
        'natn',
        'pport_issue_date',
        'pport_expr_date',
        'pport_no',
        'pin',
        'mob_phone_no',
        'user_id',
        'email',
        'birth_place',
        'mid_name',
        'valid',
        'user_type',
        'sess_id',
        'ret_cd',
        'first_name',
        'full_name',
    ];
}
