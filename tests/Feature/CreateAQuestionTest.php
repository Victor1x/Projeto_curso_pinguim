<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertAuthenticated, assertDatabaseCount, assertDatabaseHas};

test("pergunda so deve ter 255 caracteris", function () {

    //ARRANGE :: PREPARA

    $user = User::factory()->create();
    actingAs($user);

    assertAuthenticated();

    // ACT :: AGIR

    $request = $this->post(route('questions.store'), [
        "questions" => str_repeat("*", 254) . "?", // str_repeat recebe o que você quer repetir e quantas vezes quer repetir.
    ]);

    // ASSER :: VERIFICAR

    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('tb_questions', 1);
    assertDatabaseHas("tb_questions", [
        "questions" => str_repeat("*", 254) . "?",
    ]);

});

it("não posso conseguir mandar uma pergunta sem um ponto de interrogação no final", function () {

    expect(true)->toBeTrue();

})->todo();

it("precisa ter mais do que 10 letras", function () {

    expect(true)->toBeTrue();

})->todo();
