<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Container\ContainerInterface;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;
use PDOException;



class AuthController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        // Inject the container to have access to the settings
        $this->container = $container;
    }

    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

        // Retrieve user credentials from the database
        $dbCredentials = $this->getUserCredentialsFromDatabase($username, $password);

        // Check if user exists and password matches
        if ($dbCredentials !== null) {
            // Generate and return the JWT token
            $token = $this->generateToken([
                'username' => $username,
                'profilo' => [
                    'nome' => $dbCredentials['Nome'],
                    'cognome' => $dbCredentials['Cognome']
                ]
            ]);
            return $response->withJson(['token' => $token]);
        } else {
            return $response->withStatus(401)->withJson(['error' => 'Invalid username or password']);
        }
    }


    protected function getUserCredentialsFromDatabase($username, $password)
    {
        // Connessione al database
        $dsn = 'mysql:host=localhost;dbname=betterF1';
        $dbUsername = 'root'; // Sostituisci con il tuo nome utente del database
        $dbPassword = ''; // Sostituisci con la tua password del database

        try {
            $pdo = new PDO($dsn, $dbUsername, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepara e esegue la query per recuperare le credenziali dell'utente
            $statement = $pdo->prepare('SELECT * FROM Utente WHERE Username = :Username');
            $statement->execute([':Username' => $username]);

            // Ottiene le credenziali dell'utente
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            // Verifica se l'utente esiste e la password corrisponde
            if ($user && md5($password) === $user['Password']) {
                return $user;
            } else {
                return null; // Utente non trovato o password non corrispondente
            }

            // Chiude la connessione al database
            $pdo = null;
        } catch (PDOException $e) {
            // Gestisci eventuali errori di connessione al database
            echo 'Errore di connessione al database: ' . $e->getMessage();
        }
    }

    protected function generateToken($data)
    {
        $secret = $this->container->get('config')['jwt']['secret'];
        $token = JWT::encode($data, $secret, 'HS256');
        return $token;
    }

    public function verify($token, Request $request, Response $response)
    {
        $secret = $this->container->get('config')['jwt']['secret'];

        try {
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            return $response->withJson(['data' => (array) $decoded]);
        } catch (\Exception $e) {
            return $response->withStatus(401)->withJson(['error' => $e->getMessage()]);
        }
    }
}