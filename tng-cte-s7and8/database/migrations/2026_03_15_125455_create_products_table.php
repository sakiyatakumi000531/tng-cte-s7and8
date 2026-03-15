<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // デフォルトで NOT NULL
            $table->increments('id');
            $table->integer('company_id'); // INT
            $table->string('product_name'); // VARCHAR
            $table->integer('price'); // INT
            $table->integer('stock'); // INT
            $table->text('comment')->nullable(); // TEXT
            $table->string('img_path')->nullable(); // VARCHAR
            $table->timestamps(); // created_at, updated_at を一括作成, TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
