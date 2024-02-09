<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'laravel_session',
        'initial',
        'count',
        'active',
        'difficulty',
        'cards',
        'random_cards',
        'matched_cards',
        'first_card',
        'verifying',
        'player_name',
        'timer_seconds',
        'total_score',
        'timer_interval',
        'show_modal',
    ];
}
