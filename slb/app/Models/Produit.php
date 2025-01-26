<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $table = 'produit';

    public function commandes(){
        return $this->belongsToMany(Commande::class, 'article_commandee')
        ->withPivot('qte_commande', 'prix_de_vente')
        ->withTimestamps();
    }
}
