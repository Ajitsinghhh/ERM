<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Password extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'account_name',
        'username',
        'encrypted_password',
        'notes',
        'category',
        'url',
        'is_favorite'
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    /**
     * Get the user that owns the password
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Encrypt and set the password
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['encrypted_password'] = Crypt::encryptString($value);
    }

    /**
     * Decrypt and get the password
     */
    public function getPasswordAttribute()
    {
        try {
            return Crypt::decryptString($this->encrypted_password);
        } catch (\Exception $e) {
            return 'Unable to decrypt';
        }
    }

    /**
     * Get decrypted password for display
     */
    public function getDecryptedPassword()
    {
        return $this->password;
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for favorites
     */
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Scope for user's passwords
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

}
