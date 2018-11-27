<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClmPartytoitemsWoUniqueId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partytoitems', function (Blueprint $table) {
            $table->string('woUniqueId', 50)->unique()->nullable()->after('woStatus')->comment('workorder table same token generate, Send link to party for send item against work order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partytoitems', function (Blueprint $table) {
            $table->dropColumn('woUniqueId');
        });
    }
}
