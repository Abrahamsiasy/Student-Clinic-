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
        Schema::table('product_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');

            // $table
            //     ->foreign('approved_by')
            //     ->references('id')
            //     ->on('users');


        });
    }

    public function down()
    {
        Schema::table('product_responses', function (Blueprint $table) {
            $table->dropColumn('approved_by');

        });
    }
};
