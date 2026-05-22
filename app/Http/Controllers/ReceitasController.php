<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receita;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ReceitaController extends Controller
{

    public function buscar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'busca' => ['required', 'string', 'min:3', 'max:500'],
        ], [
            'busca.required' => 'O campo busca é obrigatório.',
            'busca.min' => 'A busca deve ter pelo menos 3 caracteres.',
        ]);

        $busca = $dados['busca'];

        try {
            $ingredientes = $this->interpretarComGroq($busca);
        } catch (RuntimeException $e) {
            return response()->json([
                'mensagem' => $e->getMessage(),
            ], 503);
        }

        $query = Receita::query();

        if (empty($ingredientes)) {
            return response()->json([
                'busca' => $busca,
                'ingredientes' => $ingredientes,
                'mensagem' => 'Receitas não encontradas',
                'receitas' => [],
            ], 404);
        }

        foreach ($ingredientes as $ingrediente) {
            $query->where('ingredientes', 'like', '%'.$ingrediente.'%');
        }

        $receitas = $query
            ->orderBy('titulo')
            ->get();

        return response()->json([
            'busca' => $busca,
            'ingredientes' => $ingredientes,
            'receitas' => $receitas,
        ]);
    }

    private function interpretarComGroq(string $busca): array
    {
        $apiKey = config('services.groq.key');

        try {
            $resposta = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model'),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => <<<'PROMPT'
Você interpreta pedidos de receitas em português e extrai os ingredientes mencionados.

Retorne APENAS um JSON válido com esta estrutura:
{
  "ingredientes": ["ingrediente1", "ingrediente2"]
}

Regras:
- "ingredientes": lista de ingredientes mencionados ou implícitos no pedido. Array vazio se nenhum.
- Não invente receitas. Apenas extraia ingredientes do texto.
PROMPT,
                        ],
                        [
                            'role' => 'user',
                            'content' => $busca,
                        ],
                    ],
                    'response_format' => ['type' => 'json_object'],
                    'temperature' => 0.1,
                ])
                ->throw()
                ->json();
        } catch (RequestException $e) {
            throw new RuntimeException(
                'Falha ao consultar a Groq: '.$e->getMessage(),
                previous: $e
            );
        }

        $conteudo = $resposta['choices'][0]['message']['content'];

        $dados = json_decode($conteudo, true);


        $ingredientes = [];

        foreach ($dados['ingredientes'] ?? [] as $ingrediente) {
            if (is_string($ingrediente) && trim($ingrediente) !== '') {
                $ingredientes[] = mb_strtolower(trim($ingrediente));
            }
        }

        return $ingredientes;
    }
}