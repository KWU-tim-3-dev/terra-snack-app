<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_customizable_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customization_option_id')
                ->constrained()
                ->cascadeOnDelete();

            // FIX: shorter index name (avoid MySQL index length error)
            $table->unique(
                ['product_id', 'customization_option_id'],
                'prod_cust_opt_unique'
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_customizable_options');
    }
};
