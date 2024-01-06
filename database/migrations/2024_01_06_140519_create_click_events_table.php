<?php

use App\Models\Domain;
use App\Models\ShortLink;
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
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Domain::class);
            $table->foreignIdFor(ShortLink::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('click_events');
    }
};
