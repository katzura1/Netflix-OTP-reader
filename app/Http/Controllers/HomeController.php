<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function getInbox()
    {
        $inbox = $this->fetchNetflixEmails();
        return view('welcome', compact('inbox'));
    }

    /**
     * Fetch Netflix emails with cache (30 seconds)
     *
     * @return array
     */
    public static function fetchNetflixEmails(): array
    {
        return Cache::remember('netflix_inbox', 30, function () {
            $oClient = \Webklex\IMAP\Facades\Client::account('default');
            $oClient->connect();

            /** @var \Webklex\PHPIMAP\Folder $folder */
            $folder = $oClient->getFolder('NETFLIX');

            //Get all Messages of the current Mailbox $folder (last 30 minutes)
            /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
            $messages = $folder->messages()
                ->all()
                ->limit(50)
                ->since(\Carbon\Carbon::now()->subMinutes(30))
                ->setFetchOrderAsc()
                ->fetchOrderAsc()
                ->get();

            $inbox = [];

            foreach ($messages as $message) {
                $bodyText = $message->getTextBody(true);
                //cari text yang berawalan [https://www.netflix.com/account dan ambil seluruhnya sampai dengan ]
                preg_match('/\[https:\/\/www\.netflix\.com\/account.*?\]/', $bodyText, $matches);
                $accountLink = $matches[0] ?? '';
                // remove [ dan ]
                $accountLink = trim($accountLink, '[]');

                $inbox[] = [
                    'uid'          => $message->getUid(),
                    'subject'      => $message->subject->toString(),
                    'from'         => $message->from->toString(),
                    'date'         => $message->date->toString(),
                    'human_date'   => \Carbon\Carbon::parse($message->date->toString())->diffForHumans(),
                    'text_body'    => mb_substr($message->getTextBody(true), 0, 100),
                    'account_link' => $accountLink,
                ];
            }

            // reverse array
            return array_reverse($inbox);
        });
    }
}
