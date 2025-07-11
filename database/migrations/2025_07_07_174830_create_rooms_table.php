<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // habitacion_id
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('nombre');
            $table->integer('num_max_personas');
            $table->integer('camas');
            $table->decimal('costo_noche', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
