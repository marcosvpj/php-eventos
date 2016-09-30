<?php

class EventHandler {

    public $listners = [];

    public function __construct()
    {
        echo "Classe Eventos() inicializada.\n";
    }

    public function addListner($evento, callable $callback)
    {
        echo "Evento cadastrado '{$evento}'\n";
        $this->eventHandler->listners[$evento] = $callback;
    }

    public function sendEvent($evento, $params = [])
    {
        echo "Evento enviado '{$evento}'\n";
        if (isset($this->eventHandler->listners[$evento])) {
            $this->eventHandler->listners[$evento](...$params);
        }
    }
}


class Cliente {

    private $eventHandler;

    public $nome;

    public function __construct($eventHandler)
    {
        echo "Classe Cliente() inicializada.\n";
        $this->eventHandler = $eventHandler;
    }

    function cadastro($nome) {
        echo "Novo cadastro do {$nome}\n";
        $this->nome = $nome;
        $this->eventHandler->sendEvent('cadastro', [$this]);
    }
}


class Email {

    private $eventHandler;

    public function __construct($eventHandler)
    {
        echo "Classe Email() inicializada.\n";
        $this->eventHandler = $eventHandler;
    }

    public function enviarEmail($cliente)
    {
        echo "Enviar email para {$cliente->nome}\n";
    }
}


$eventHandler = new EventHandler();

$a = new Cliente($eventHandler);
$b = new Cliente($eventHandler);
$email = new Email($eventHandler);

$eventHandler->addListner('cadastro', [$email, 'enviarEmail']);

$a->cadastro('Cliente A');
$b->cadastro('Cliente B');
$a->cadastro('Cliente A');
