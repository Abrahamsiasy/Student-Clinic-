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
            $table->string('tin_number')->nullable();
            $table->smallInteger('status')->nullable();
            $table->unsignedBigInteger('product_request_id')->default(0)->nullable();
            $table->foreign('product_request_id')->references('id')->on('product_requests');

            // $table->text('to_be_approved')->nullable()->after('approval_amount');
        });
    }

    public function down()
    {
        Schema::table('product_responses', function (Blueprint $table) {
            $table->dropColumn('tin_number');
            $table->dropColumn('product_request_id');
        });
    }
};
