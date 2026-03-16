<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Actions\AuthRegisterActions;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterAgentRequest;
use App\Http\Requests\RegisterClientRequest;

class AuthRegisterController extends Controller
{
    public function registerAgent(RegisterAgentRequest $request): JsonResponse
    {
        try {
            // Realiza o registro do agente
            $user = AuthRegisterActions::registerAgent($request->validated());

            // Realiza o login do usuário registrado
            Auth::login($user);

            // Retorna uma resposta JSON de sucesso
            return response()->json([
                'status' => 'success',
                'message' => 'Agente registrado com sucesso.',
            ], 200); // 200 é o código HTTP para sucesso
        } catch (\Exception $e) {
            // Retorna uma resposta JSON de erro em caso de falha
            return response()->json([
                'status' => 'error',
                'message' => 'Falha ao registrar o agente.',
                'error' => $e->getMessage(), // Inclui a mensagem de erro para depuração
            ], 500); // 500 é o código HTTP para erro interno do servidor
        }
    }


    public function registerClient(RegisterClientRequest $request): JsonResponse
    {
        try {
            // Registra o cliente
            $user = AuthRegisterActions::registerClient($request->validated());

            // Cria o token de autenticação para o usuário
            $token = $user->createToken('auth_token')->plainTextToken;

            // Retorna a resposta com o token gerado
            return response()->json([
                'status' => 'success',
                'message' => 'Client registered and logged in successfully.',
                'data' => $user,
                'access_token' => $token, // Envia o token gerado
                'token_type' => 'Bearer', // Tipo de token
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Client registration failed.',
            ], 500);
        }
    }

}
