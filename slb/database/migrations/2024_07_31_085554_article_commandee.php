<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_commandee', function (Blueprint $table){
            $table->foreignId('commande_id')->constrained('commande')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produit')->onDelete('cascade');
            $table->integer('qte_commande');
            $table->decimal('prix_de_vente', 10, 2);
            $table->primary(['commande_id','produit_id']);
            $table->timestamps();
           
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_commandee');
    }
    
};
