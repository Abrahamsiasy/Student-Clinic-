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
        Schema::table('prescriptions', function (Blueprint $table) {

            //
            $table->unsignedBigInteger('items_in_pharmacies_id')->nullable();
            $table->foreign('items_in_pharmacies_id')->references('id')->on('items_in_pharmacies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            //


            $table->dropForeign(['items_in_pharmacies_id']);
            $table->dropColumn('items_in_pharmacies_id');
        });
    }
};
