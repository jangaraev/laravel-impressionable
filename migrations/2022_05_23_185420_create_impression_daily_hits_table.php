<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jangaraev\LaravelImpressionable\Models\Impression;

class CreateImpressionDailyHitsTable extends Migration
{
    public function up()
    {
        Schema::create('impression_daily_hits', function (Blueprint $table) {
            $table->date('date');
            $table->foreignIdFor(Impression::class);
            $table->bigInteger('ip');

            $table->foreign('impression_id')->on('impressions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['impression_id', 'ip', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('impression_daily_hits');
    }
}
