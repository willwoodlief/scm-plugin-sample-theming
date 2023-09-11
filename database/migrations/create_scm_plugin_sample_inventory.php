<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scm_plugin_sample_inventory', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')->nullable(false)
                ->index()
                ->constrained()
                ->references('id')
                ->on('invoices')
                ->cascadeOnDelete();

            $table->integer('invoice_importance')->default(0)->nullable(false);
            $table->string('invoice_color_code')->collation('utf8mb4_0900_ai_ci')->charset('utf8mb4')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scm_plugin_tests');
    }
};
