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
        Schema::table('product_requests', function (Blueprint $table) {
            $table->decimal('approval_amount')->default(0); // Added approval_amount column
    });
    }

    public function down()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropColumn('approval_amount');
        });
    }
};
