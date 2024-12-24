<?php
  
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'division';
    protected $fillable = ['name'];

    public function accuraMembers()
    {
        return $this->hasMany(AccuraMember::class);
    }
}