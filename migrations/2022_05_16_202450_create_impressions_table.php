<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpressionsTable extends Migration
{
    public function up()
    {
        Schema::create('impressions', function (Blueprint $table) {
            $table->date('date');
            $table->morphs('impressionable');
            $table->bigInteger('ip');

            $table->unique(['impressionable_type', 'impressionable_id', 'ip', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('impressions');
    }
}
