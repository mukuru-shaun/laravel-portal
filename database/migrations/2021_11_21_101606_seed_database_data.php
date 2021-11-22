<?php

use App\Models\Database;
use App\Models\DatabaseServer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedDatabaseData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $servers   = [];
        $servers[] = [
            'name'         => 'mukuru001-prd-dat',
            'display_name' => 'Valtari / Kahuna Production',
            'databases'    => [
                ['name' => 'mukuru_migration', 'display_name' => 'Mukuru Migration'],
                ['name' => 'mukuru_migration_archive', 'display_name' => 'Mukuru Migration Archive'],
                ['name' => 'service_bands', 'display_name' => 'Service Bands'],
                ['name' => 'audit_logs', 'display_name' => 'Kahuna Audit Logs'],
                ['name' => 'identifiers', 'display_name' => 'Kahuna Identifiers'],
                ['name' => 'money_schemes', 'display_name' => 'Kahuna Money Schemes'],
            ],
        ];

        $servers[] = [
            'name'         => 'mukuru-000-prd-requestlogs',
            'display_name' => 'Request Logs Production',
            'databases'    => [
                ['name' => 'requestlogs', 'display_name' => 'Request Logs'],
                ['name' => 'requestlogs_archive', 'display_name' => 'Request Logs Archive'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-taurus-consent-app-prd',
            'display_name' => 'Taurus Consent Production',
            'databases'    => [
                ['name' => 'taurus-consent', 'display_name' => 'Taurus Consent'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-taurus-ledger-app-prd',
            'display_name' => 'Taurus Ledger Production',
            'databases'    => [
                ['name' => 'taurus-ledger', 'display_name' => 'Taurus Ledger'],
            ],
        ];
        $servers[] = [
            'name'         => 'rds-taurus-ledger-reporting-app-prd',
            'display_name' => 'Taurus Ledger Reporting Production',
            'databases'    => [
                ['name' => 'taurus-ledger-reporting', 'display_name' => 'Taurus Ledger Reporting'],
            ],
        ];
        $servers[] = [
            'name'         => 'rds-taurus-wallet-app-prd',
            'display_name' => 'Taurus Wallet Production',
            'databases'    => [
                ['name' => 'taurus-wallet', 'display_name' => 'Taurus Wallet'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-docserver-app-prd-af-south-1',
            'display_name' => 'Doc Server Production',
            'databases'    => [
                ['name' => 'docsrv', 'display_name' => 'Doc Server'],
            ],
        ];
        $servers[] = [
            'name'         => 'rds-watchlist-app-prd',
            'display_name' => 'Watchlist Production',
            'databases'    => [
                ['name' => 'watchlist_aml', 'display_name' => 'Watchlist'],
                ['name' => 'watchlist_aml_log', 'display_name' => 'Watchlist Log'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-keycloak-app-prd',
            'display_name' => 'Keycloak Production',
            'databases'    => [
                ['name' => 'keycloak', 'display_name' => 'Keycloak'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-xcally-app-prd-afsouth1',
            'display_name' => 'Xcally Production',
            'databases'    => [
                ['name' => 'xcally', 'display_name' => 'Xcally'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-sharedv8-app-stg-afsouth1',
            'display_name' => 'Xcally Staging',
            'databases'    => [
                ['name' => 'xcally', 'display_name' => 'Xcally'],
            ],
        ];

        $servers[] = [
            'name'         => 'rds-verify-app-prd',
            'display_name' => 'Verifications Production',
            'databases'    => [
                ['name' => 'verify', 'display_name' => 'Verifications'],
            ],
        ];

        $servers[] = [
            'name'         => 'malawi-yoda',
            'display_name' => 'Mukuru Green Production',
            'databases'    => [
                ['name' => 'ws', 'display_name' => 'WS'],
                ['name' => 'myzoona', 'display_name' => 'My Zoona'],
            ],
        ];

        $servers[] = [
            'name'         => 'mukuru-000-stg-dat',
            'display_name' => 'Valtari / Kahuna Staging',
            'databases'    => [
                ['name' => '%mukuru_migration', 'display_name' => 'Mukuru Migration'],
                ['name' => '%mukuru_migration_archive', 'display_name' => 'Mukuru Migration Archive'],
                ['name' => '%service_bands', 'display_name' => 'Service Bands'],
                ['name' => '%audit_logs', 'display_name' => 'Kahuna Audit Logs'],
                ['name' => '%identifiers', 'display_name' => 'Kahuna Identifiers'],
                ['name' => '%money_schemes', 'display_name' => 'Kahuna Money Schemes'],
                ['name' => '%requestlogs', 'display_name' => 'Request Logs'],
                ['name' => '%requestlogs_archive', 'display_name' => 'Request Logs Archive'],
            ],
        ];

        $servers[] = [
            'name'         => 'shared-rds-app-stg',
            'display_name' => 'K8s Staging',
            'databases'    => [
                ['name' => 'kannel', 'display_name' => 'Kannel'],
                ['name' => 'kanneldlr', 'display_name' => 'Kannel DLR'],
                ['name' => 'taurus-delivery-status', 'display_name' => 'Taurus Delivery Status'],
                ['name' => 'taurus-consent-staging', 'display_name' => 'Taurus Consent'],
                ['name' => 'taurus-consent-review-%', 'display_name' => 'Taurus Consent'],
                ['name' => 'taurus-discount-staging', 'display_name' => 'Taurus Discount'],
                ['name' => 'taurus-discount-review-%', 'display_name' => 'Taurus Discount'],
                ['name' => 'taurus-ledger-reporting-staging', 'display_name' => 'Taurus Ledger Reporting'],
                ['name' => 'taurus-ledger-reporting-review-%', 'display_name' => 'Taurus Ledger Reporting'],
                ['name' => 'taurus-ledger-staging', 'display_name' => 'Taurus Ledger'],
                ['name' => 'taurus-ledger-review-%', 'display_name' => 'Taurus Ledger'],
                ['name' => 'taurus-price-scraper-staging', 'display_name' => 'Taurus Price Scraper'],
                ['name' => 'taurus-price-scraper-review-%', 'display_name' => 'Taurus Price Scraper'],
                ['name' => 'taurus-wallet-staging', 'display_name' => 'Taurus Wallet'],
                ['name' => 'taurus-wallet-review-%', 'display_name' => 'Taurus Wallet'],
                ['name' => 'verify-staging', 'display_name' => 'Verifications'],
                ['name' => 'verify-review-%', 'display_name' => 'Verifications'],
                ['name' => 'watchlist-staging', 'display_name' => 'Watchlist'],
                ['name' => 'watchlist_log', 'display_name' => 'Watchlist Log'],
                ['name' => 'watchlist-review-%', 'display_name' => 'Watchlist'],
            ],
        ];

        foreach ($servers as $server) {
            $databaseServer = DatabaseServer::create([
                'name' => $server['name'],
                'display_name' => $server['display_name'],
                'type' => 'mysql',
            ]);

            foreach ($server['databases'] as $database) {
                $databaseServer->databases()->save(new Database($database));
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
