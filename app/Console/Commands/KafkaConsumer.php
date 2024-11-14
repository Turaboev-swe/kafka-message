<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'app:kafka-consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $consumer = Kafka::createConsumer(['movies'])
            ->withHandler(function (KafkaConsumerMessage $message) {
                event(new MovieDataReceived(json_encode($message->getBody())));
                $this->info('Received message: ' . json_encode($message->getBody()));
            })->build();

        $consumer->consume();
    }
}
