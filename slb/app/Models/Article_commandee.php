<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_commandee extends Model
{
    use HasFactory;
    protected $table = 'article_commandee';

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    // Relation avec le modèle Commande (si nécessaire)
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}
