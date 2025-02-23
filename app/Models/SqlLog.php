<?php
/**
 * Created by PhpStorm.
 * User: kiven
 * Date: 2025/2/23
 * Time: 15:36
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqlLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sql',
        'error'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}