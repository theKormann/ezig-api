<?php

namespace Database\Seeders;

use App\Models\Receita;
use Illuminate\Database\Seeder;

class ReceitaSeeder extends Seeder
{
    public function run(): void
    {
        $receitas = [
            [
                'titulo' => 'Frango cremoso com queijo',
                'descricao' => 'Prato rápido e cremoso para o jantar.',
                'ingredientes' => 'frango, queijo, creme de leite, alho, sal, pimenta',
                'modo_preparo' => 'Tempere o frango, doure na panela, adicione o creme de leite e o queijo até derreter. Sirva quente.',
            ],
            [
                'titulo' => 'Salada de frango grelhado',
                'descricao' => 'Refeição leve e nutritiva.',
                'ingredientes' => 'frango, alface, tomate, cebola, azeite, limão',
                'modo_preparo' => 'Grelhe o frango, fatie e misture com os vegetais. Regue com azeite e limão.',
            ],
            [
                'titulo' => 'Omelete de queijo',
                'descricao' => 'Café da manhã simples em poucos minutos.',
                'ingredientes' => 'ovos, queijo, manteiga, sal, cebolinha',
                'modo_preparo' => 'Bata os ovos, despeje na frigideira com manteiga, adicione o queijo e dobre ao firmar.',
            ],
            [
                'titulo' => 'Macarrão ao molho branco',
                'descricao' => 'Massa cremosa com queijo parmesão.',
                'ingredientes' => 'macarrão, leite, queijo parmesão, manteiga, farinha, noz-moscada',
                'modo_preparo' => 'Cozinhe o macarrão. Prepare o molho branco e misture com a massa al dente.',
            ],
            [
                'titulo' => 'Wrap de frango',
                'descricao' => 'Lanche prático para levar.',
                'ingredientes' => 'frango, tortilha, alface, tomate, maionese',
                'modo_preparo' => 'Grelhe o frango em tiras, monte o wrap com os demais ingredientes e enrole.',
            ],
            [
                'titulo' => 'Sopa de legumes',
                'descricao' => 'Sopa reconfortante sem carne.',
                'ingredientes' => 'cenoura, batata, abobrinha, cebola, caldo de legumes, azeite',
                'modo_preparo' => 'Refogue os legumes, cubra com caldo e cozinhe até ficarem macios. Bata parcialmente se desejar.',
            ],
            [
                'titulo' => 'Pão de queijo caseiro',
                'descricao' => 'Lanche brasileiro clássico.',
                'ingredientes' => 'polvilho azedo, polvilho doce, queijo, ovos, leite, óleo, sal',
                'modo_preparo' => 'Misture os polvilhos com líquidos quentes, incorpore ovos e queijo, modele e asse até dourar.',
            ],
        
        ];

        foreach ($receitas as $receita) {
            Receita::create($receita);
        }
    }
}