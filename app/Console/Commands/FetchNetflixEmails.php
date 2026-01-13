<?php
namespace App\Console\Commands;

use App\Http\Controllers\HomeController;
use Illuminate\Console\Command;

class FetchNetflixEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netflix:fetch-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Netflix emails from IMAP and cache them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching Netflix emails...');

        try {
            $inbox = HomeController::fetchNetflixEmails();
            $count = count($inbox);

            $this->info("Successfully fetched {$count} Netflix email(s)");

            if ($count > 0) {
                $this->table(
                    ['Subject', 'From', 'Date'],
                    array_map(function ($email) {
                        return [
                            $email['subject'],
                            $email['from'],
                            $email['human_date'],
                        ];
                    }, $inbox)
                );
            } else {
                $this->warn('No emails found in the last 30 minutes');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to fetch emails: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
