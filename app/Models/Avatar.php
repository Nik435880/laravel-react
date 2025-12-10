<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $avatar_path
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereAvatarPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereUserId($value)
 * @mixin \Eloquent
 */
class Avatar extends Model
{
    protected $fillable = [
        "avatar_path",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
