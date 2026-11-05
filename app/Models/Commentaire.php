<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
use HasFactory;
protected $fillable = ['contenu', 'publication_id', 'user_id'];
public function publication(): BelongsTo
{
return $this->belongsTo(Publication::class);
}
public function auteur(): BelongsTo
{
return $this->belongsTo(User::class, 'user_id');
}
}