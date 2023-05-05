<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otpVerification extends Model
{
    use HasFactory;

    protected $table        = 'otp_verifications';

    protected $primaryKey   = 'otp_verification_id';
}
