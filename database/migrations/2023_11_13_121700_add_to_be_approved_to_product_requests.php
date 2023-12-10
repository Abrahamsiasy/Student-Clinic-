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
            $table->text('to_be_approved')->nullable()->after('approval_amount');
        });
    }

    public function down()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropColumn('to_be_approved');
        });
    }
};
