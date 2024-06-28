<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Client extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'phone', // Add any other attributes you want to be mass assignable here
        'name',
        'last_name',
        'email',
        'birthday',
        'service_id',
        'states',
        'assessment',
    ];

    protected $allowedSorts =[
        'states'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
