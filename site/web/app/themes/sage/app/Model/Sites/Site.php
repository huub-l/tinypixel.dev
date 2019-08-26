<?php

namespace App\Model\Sites;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'site-status';

    protected $fillable = ['domain', 'expiration', 'tag', 'issuer'];
}
