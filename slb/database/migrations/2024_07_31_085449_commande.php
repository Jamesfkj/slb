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
        Schema::create("commande", function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande');
            $table->unsignedBigInteger('users_id');  
            $table->foreign('users_id')->references('id')->on('utilisateur')->onDelete('cascade');
            $table->decimal('montant',10 ,2)->nullable(); 
            $table->string('etat')->default('en cours');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("commande");
    }
    
};
