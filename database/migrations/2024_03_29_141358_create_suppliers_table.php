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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->integer('contact_number');
            $table->string('address');
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('prod_id')->nullable();
            $table->foreign('prod_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::table('suppliers', function (Blueprint $table) {
            // Drop foreign key constraint if exists
            $table->dropForeign(['prod_id']);
        });

        Schema::dropIfExists('suppliers');
    }
};
