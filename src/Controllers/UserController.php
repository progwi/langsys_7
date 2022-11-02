<?php
namespace App\Controllers;

use App\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController {
   private $app;
   private $userService;
   private $entityManager;

   public function __construct($app, $entityManager) {
      $this->app = $app;
      $this->entityManager = $entityManager;
      $this->userService = new UserService($entityManager);
   }

   public function buildRoutes() {
      $this->app->get('/users', [$this, 'getAll']);
      $this->app->get('/users/{userId}', [$this, 'getById']);
      $this->app->post('/users', [$this, 'create']);    
   }

   function getAll(Request $request, Response $response, $args) {
		$usersList = json_encode($this->userService->query(1), JSON_PRETTY_PRINT);
		$response->getBody()->write($usersList);
		return $response;
	}

   function getById(Request $request, Response $response, $args) {
		$userId = $args['userId'];
		$user = json_encode($this->userService->getUser($userId), JSON_PRETTY_PRINT);
		$response->getBody()->write($user);
		return $response;
	}

   function create(Request $request, Response $response, $args) {
      $user = json_decode($request->getBody(), true);
     
		$user = json_encode($this->userService->create($user), JSON_PRETTY_PRINT);
		$response->getBody()->write($user);
		return $response;
	}
}
