<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpressionsTable extends Migration
{
    public function up()
    {
        Schema::create('impressions', function (Blueprint $table) {
            $table->morphs('impressionable');
            $table->bigInteger('value')->unsigned()->default(0);

            $table->unique(['impressionable_type', 'impressionable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('impressions');
    }
}
