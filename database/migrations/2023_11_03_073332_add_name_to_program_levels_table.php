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
        Schema::table('program_levels', function (Blueprint $table) {
            //
            Schema::table('program_levels', function (Blueprint $table) {
                $table->string('name', 150);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_levels', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
