<?php
namespace MiniAgent;

use MiniAgent\Plugins\IPlugin;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server;
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
        $loop = \React\EventLoop\Factory::create();

//        $server = new Server(function (ServerRequestInterface $request) use ($loop) {
//
//
//
//
//            $process = new \React\ChildProcess\Process('echo foo');
//            $process->start($loop);
//
//            $process->stdout->on('data', function ($chunk) {
//                echo $chunk;
//            });
//
//
////            $params = $request->getQueryParams();
//
////            if($request->getUri() == 'command' && $params['command']){
////
////            }
//
//
//            return new Response(
//                200,
//                array(
//                    'Content-Type' => 'text/plain'
//                ),
//                "Hello World!\n"
//            );
//
//
//        });

        $socket = new \React\Socket\Server($this->config->port, $loop);
//        $server->listen($socket);

        $loop->run();

    }
}