<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use HasFactory;

    use Notifiable;
    
    /**
     * Get the doctor associated with the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'id');
    }
}
