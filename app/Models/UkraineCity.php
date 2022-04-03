<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkraineCity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ukraine_cities';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['city_name', 'latitude', 'longitude', 'population'];
}
