<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function getInbox()
    {
        $oClient = \Webklex\IMAP\Facades\Client::account('default');
        $oClient->connect();
        /** @var \Webklex\PHPIMAP\Folder $folder */
        $folders = $oClient->getFolders();
        $folder  = $oClient->getFolder('NETFLIX');
        //Get all Messages of the current Mailbox $folder
        /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        $messages = $folder->messages()
            ->all()
            ->limit(10)
            ->setFetchOrderAsc()
            ->fetchOrderAsc()
            ->since(\Carbon\Carbon::now()->subDays(5))
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

        return view('welcome', compact('inbox'));
    }
}
