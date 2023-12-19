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
            $table->text('approved_at')->nullable()->after('to_be_approved');
            $table->date('rejected_at')->nullable()->after('approved_at');
        });
    }

    public function down()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropColumn('approved_at');
            $table->dropColumn('rejected_at');
        });
    }
};
