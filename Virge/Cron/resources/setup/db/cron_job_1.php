<?php
use Virge\Database\Component\Schema;
/**
 * Setup schema migration database tables (using the schema migration tool)
 * @author Michael Kramer
 */

Schema::create(function() {
    Schema::alter('virge_cron_job');
    Schema::string('status')->setAfter('id')->setIndex('INDEX');
    Schema::end();
});