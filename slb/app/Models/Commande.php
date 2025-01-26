<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $table='commande';

    public function produits(){
        return $this->belongsToMany(Produit::class, 'article_commandee')
        ->withPivot('qte_commande', 'prix_de_vente')
        ->withTimestamps();
    }


}
