<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private UserRepository $repository;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * @Route ("/login", methods={"POST"});
     */
    public function login(Request $request): Response
    {
        #dados do request em json
        $dadosJson = json_decode($request->getContent());

        #verificando se os dados passados no requeste não são nulos
        if (is_null($dadosJson->username) || is_null($dadosJson->password)) {
            return new JsonResponse([
                'error' => 'Envie usuário e senha'
            ]);
        }

        #buscando apenas um usuário com o findByOne
        $user = $this->repository->findOneBy([
            'username' => $dadosJson->username
        ]);

        #verificando se a senha confere com a que esta no banco, usando o UserPassword
        if (!$this->encoder->isPasswordValid($user, $dadosJson->password)) {
            return new JsonResponse([
                'error' => 'Usuário e senha inválidos'
            ], Response::HTTP_UNAUTHORIZED);
        }

        #craindo o toke jwt, passando um array, chave e o algoritmo
        $jwt = JWT::encode(['username' => $user->getUsername()], '098@/\2358@-fw124', 'HS256');

        return new JsonResponse([
            'access_token' => $jwt
        ]);
    }
}