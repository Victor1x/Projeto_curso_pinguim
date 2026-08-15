<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionsController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // esse metodo get nao tem aver com o metodo htttp mais si get de pega um dado
        //        dd(request()->get("question"));
        //        dd(request()->question); // vc pode pega o dado pela chave de valor dele na array metodo magico question seria o name do inplut\
        //        dd(request()->all());

        $attributes = $request->validate([
            'questions' => [
                'required',
                'string',
                'max:255',
                'min:10',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '?')) {
                        $fail("Tem certeza de que isso é uma pergunta? Está faltando o ponto de interrogação no final.");
                    }
                },
            ],
        ]);

        Questions::query()->create($attributes);

        return to_route("dashboard");
    }
}
