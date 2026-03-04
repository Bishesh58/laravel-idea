<?php

namespace App\Models;

use App\IdeaStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'image_path',
        'links',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'links' => AsArrayObject::class,
            'status' => IdeaStatus::class,
        ];
    }

    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'status' => IdeaStatus::Pending->value,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }
}
