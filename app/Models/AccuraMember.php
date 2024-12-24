<?php
  
  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  
  class AccuraMember extends Model
  {
      use HasFactory;
  
      protected $fillable = ['first_name', 'last_name', 'summary','dob', 'division_id'];
  
      public function division()
      {
          return $this->belongsTo(Division::class);
      }
  }
  
  