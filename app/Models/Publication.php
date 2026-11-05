<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Publication extends Model
{
use HasFactory, SoftDeletes;
protected $fillable = [
'titre', 'contenu', 'categorie_id', 'user_id',
];
public function categorie(): BelongsTo
{
return $this->belongsTo(Categorie::class);
}
public function auteur(): BelongsTo
{
return $this->belongsTo(User::class, 'user_id');
}
public function commentaires(): HasMany
{
return $this->hasMany(Commentaire::class);
}
public function tags(): BelongsToMany
{
return $this->belongsToMany(Tag::class);
}
}   