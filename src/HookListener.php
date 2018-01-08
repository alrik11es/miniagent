<?php
namespace MiniAgent;

use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Server;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HookListener
{

    private $config;
    /** @var OutputInterface */
    private $output;
    /** @var InputInterface */
    private $input;

    /**
     * HookListener constructor.
     * @param $config
     * @param $output
     * @param $input
     */
    public function __construct($config, $output, $input)
    {
        $this->config = $config;
        $this->output = $output;
        $this->input = $input;
    }


    public function startup()
    {
        $loop = Factory::create();

        $tls_config = array(
            'tls' => array(
                'local_cert' => file_exists($this->config->certificate) ? $this->config->certificate : '',
            )
        );

        $server = new Server($this->config->port, $loop, $tls_config);
        $server->on('connection', function (ConnectionInterface $conn) {
            echo '[' . $conn->getRemoteAddress() . ' connected]' . PHP_EOL;
            $conn->pipe($conn);
        });

        $server->on('error', 'printf');
        echo 'Listening on ' . $server->getAddress() . PHP_EOL;
        $loop->run();

    }
}