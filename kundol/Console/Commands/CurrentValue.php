<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CurrentValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:current_value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Current Value of accounts individually in transaction detail table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement("CREATE OR REPLACE VIEW current_value AS SELECT transaction_detail.reference_id ,(SUM(transaction_detail.dr_amount)-SUM(transaction_detail.cr_amount)) AS total_amount , accounts.name,accounts.type FROM accounts LEFT JOIN transaction_detail ON accounts.id = transaction_detail.account_id WHERE accounts.type IN ('simple_product','variable_product') GROUP BY accounts.type,accounts.reference_id HAVING (SUM(transaction_detail.cr_amount)-SUM(transaction_detail.dr_amount)) IS NOT NULL");
        DB::statement("CREATE OR REPLACE VIEW expense_report AS SELECT description,dr_amount AS amount FROM `transaction_detail` WHERE account_id IN (SELECT id FROM accounts WHERE account_type = 'expense')");
    }
}
