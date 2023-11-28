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
            $table->text('reason_of_rejection')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropColumn('reason_of_rejection');
        });
    }
};
