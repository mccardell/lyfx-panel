<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\MailchimpHelper;

class ContactsSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send consumers and newsletter contacts to MailChimp';

    /**
     * Mailchimp API Helper
     *
     * @var App\Helpers\MailchimpHelper
     */
    private $mailchimpHelper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MailchimpHelper $mailchimpHelper){
        parent::__construct();

        $this->mailchimpHelper = $mailchimpHelper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->mailchimpHelper->submitNewsletter();
        $this->mailchimpHelper->submitConsumers();
        // $this->mailchimpHelper->pullNewsletter();
        // $this->mailchimpHelper->pullConsumers();
    }
}
