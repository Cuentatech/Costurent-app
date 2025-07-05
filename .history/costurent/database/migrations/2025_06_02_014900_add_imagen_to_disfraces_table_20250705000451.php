<?php
public function up()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->string('imagen')->nullable()->after('telefono'); // o donde desees colocarla
    });
}

public function down()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->dropColumn('imagen');
    });
}
