<?php

use App\Models\ApplicationInstance;
use App\Models\Database;
use App\Models\Environment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedApplicationInstanceData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $applications = [];

        $applications['Valtari'] = [
            'production' => ['mukuru_migration', 'mukuru_migration_archive', 'service_bands'],
            'staging'    => ['%mukuru_migration', '%mukuru_migration_archive', '%service_bands'],
        ];

        $applications['Audit Logs'] = [
            'production' => ['audit_logs'],
            'staging'    => ['%audit_logs'],
        ];

        $applications['Identifiers'] = [
            'production' => ['identifiers'],
            'staging'    => ['%identifiers'],
        ];

        $applications['Money Schemes'] = [
            'production' => ['money_schemes'],
            'staging'    => ['%money_schemes'],
        ];

        $applications['Request Logs'] = [
            'production' => ['requestlogs', 'requestlogs_archive'],
            'staging'    => ['%requestlogs', '%requestlogs_archive'],
        ];

        $applications['Taurus Consent'] = [
            'production' => ['taurus-consent'],
            'staging'    => ['taurus-consent-staging'],
            'review'     => ['taurus-consent-review-%'],
        ];

        $applications['Taurus Discount'] = [
            'staging' => ['taurus-discount-staging'],
            'review'  => ['taurus-discount-review-%'],
        ];

        $applications['Taurus Ledger'] = [
            'production' => ['taurus-ledger'],
            'staging'    => ['taurus-ledger-staging'],
            'review'     => ['taurus-ledger-review-%'],
        ];

        $applications['Taurus Ledger Reporting'] = [
            'production' => ['taurus-ledger-reporting'],
            'staging'    => ['taurus-ledger-reporting-staging'],
            'review'     => ['taurus-ledger-reporting-review-%'],
        ];

        $applications['Taurus Price Scraper'] = [
            'staging' => ['taurus-price-scraper-staging'],
            'review'  => ['taurus-price-scraper-review-%'],
        ];

        $applications['Taurus Wallet'] = [
            'production' => ['taurus-wallet'],
            'staging'    => ['taurus-wallet-staging'],
            'review'     => ['taurus-wallet-review-%'],
        ];

        $applications['Doc Server'] = [
            'production' => ['docsrv'],
        ];

        $applications['Watchlist'] = [
            'production' => ['watchlist_aml', 'watchlist_aml_log'],
            'staging'    => ['watchlist-staging', 'watchlist_log'],
            'review'     => ['watchlist-review-%'],
        ];

        $applications['Keycloak'] = [
            'production' => ['keycloak'],
        ];

        $applications['Verifications'] = [
            'production' => ['verify'],
            'staging'    => ['verify-staging'],
            'review'     => ['verify-review-%'],
        ];

        $applications['Mukuru Green'] = [
            'production' => ['ws', 'myzoona'],
        ];

        $applications['Kannel SMS'] = [
            'staging' => ['kannel', 'kanneldlr', 'taurus-delivery-status'],
        ];

        // The xcally databases names are not unique so the seed query won't work for them. That is done separately
//        $applications['Xcally'] = [
//            'production' => [''],
//            'staging'    => [],
//        ];

        foreach ($applications as $displayName => $instances) {
            $application = \App\Models\Application::create([
                'display_name' => $displayName,
            ]);

            foreach ($instances as $envName => $databases) {
                $applicationInstance = new ApplicationInstance([
                    'environment_id' => Environment::where('name', $envName)->first()->id,
                ]);
                $application->applicationInstances()->save($applicationInstance);

                foreach($databases as $databaseName) {
                    // No using relationships as I need to explore the hasManyThrough() thing another time
                    DB::table('application_instance_databases')->insert([
                        'application_instance_id' => $applicationInstance->id,
                        'database_id' => Database::where('name', $databaseName)->first()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
