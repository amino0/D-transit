<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->string('numdossier')->nullable();
            $table->string('numdeclaration')->nullable();
            $table->string('destinataire')->nullable();
            $table->string('agencemaritime')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('bl_number_transporteur')->nullable();
            $table->string('numoperation')->nullable();
            $table->string('numlot')->nullable();
            $table->string('voyage')->nullable();
            $table->string('portloading')->nullable();
            $table->string('qteconteneur')->nullable();
            $table->string('codehs')->nullable();
            $table->string('datearrivee_navire')->nullable();
            $table->string('marchandise')->nullable();
            $table->string('poids_marchandise')->nullable();
            $table->string('cubage_marchandise')->nullable();
            $table->string('paysdestination')->nullable();
            $table->string('transporteur')->nullable();
            $table->string('destination_marchandise')->nullable();
            $table->string('marques_machandise')->nullable();
            $table->string('soc_coc')->nullable();
            $table->string('with_without')->nullable();
            $table->string('suivipar')->nullable();
            $table->string('dategatepass')->nullable();
            $table->string('usergatepass')->nullable();
            $table->string('notegatepass')->nullable();
            $table->string('datelivraison')->nullable();
            $table->string('userlivraison')->nullable();
            $table->string('datefacturation')->nullable();
            $table->string('userfacturation')->nullable();
            $table->string('notefacturation')->nullable();
            $table->string('ouvertpar')->nullable();
            $table->string('fermerPar')->nullable();
            $table->string('dateFermer')->nullable();
            $table->string('etatdossier')->nullable();
            $table->string('observations')->nullable();
            $table->string('idclient')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
