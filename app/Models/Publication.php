<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use App\Events\PublicationCreee;

class Publication extends Model
{
use HasFactory, SoftDeletes;
protected $fillable = [ 'titre', 'contenu', 'categorie_id', 'user_id','image',
    'fichier_media','type_media','document_prive',
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
protected static function booted(): void
{
    static::deleting(function (Publication $publication): void {
        if ($publication->image) {
            Storage::disk('public')->delete($publication->image);
        }

        if ($publication->fichier_media) {
            Storage::disk('public')->delete($publication->fichier_media);
        }

        if ($publication->document_prive) {
            Storage::disk('local')->delete($publication->document_prive);
        }
    });
    static::created(function (Publication $publication): void {
    event(new PublicationCreee($publication));
});
}
public function getUrlImageAttribute(): ?string
{
    return $this->image
        ? Storage::disk('public')->url($this->image)
        : null;
}

}   