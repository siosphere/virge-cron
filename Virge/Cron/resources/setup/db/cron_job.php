<?php
use Virge\Database\Component\Schema;
/**
 * Setup schema migration database tables (using the schema migration tool)
 * @author Michael Kramer
 */

Schema::create(function() {
    Schema::table('virge_cron_job');
    Schema::id('id');
    Schema::string('name');
    Schema::string('callable');
    Schema::text('arguments');
    Schema::timestamp('scheduled_for');
    Schema::timestamp('started_on');
    Schema::string('started_by');
    Schema::timestamp('finished_on');
    Schema::text('summary'); //all output
    Schema::end();
});