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
            $table->string('country')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->unsignedTinyInteger('bot');
            $table->text('ua')->nullable();
            $table->string('referer')->nullable();
            $table->text('referer_url')->nullable();
            $table->timestamps();

            $table->index(['domain_id', 'short_link_id', 'created_at']);
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
