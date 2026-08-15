<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertAuthenticated, assertDatabaseCount, assertDatabaseHas};

test("pergunda so deve ter 255 caracteris", function () {

    //ARRANGE :: PREPARA

    $user = User::factory()->create();
    actingAs($user);

    //    assertAuthenticated(); // VERIFICA SE ESTA LOGADO

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

it("precisa ter mais do que 10 letras", function () {

    //ARRANGE :: PREPARA

    $user = User::factory()->create();
    actingAs($user); // LOGAR
    assertAuthenticated(); // VERIFICA SE ESTA LOGADO

    // ACT :: AGIR
    $request = $this->post(route('questions.store'), [
        "questions" => str_repeat("*", 8) . "?", // str_repeat recebe o que você quer repetir e quantas vezes quer repetir.
    ]);

    // ASSER :: VERIFICAR

    $request->assertSessionHasErrors(["questions" => __("validation.min.string", ["min" => 10, "attribute" => "questions"])]);
    assertDatabaseCount('tb_questions', 0);
});

it("não posso conseguir mandar uma pergunta sem um ponto de interrogação no final", function () {

    //ARRANGE :: PREPARA

    $user = User::factory()->create();
    actingAs($user); // LOGAR
    assertAuthenticated(); // VERIFICA SE ESTA LOGADO

    // ACT :: AGIR
    $request = $this->post(route('questions.store'), [
        "questions" => str_repeat("*", 10), // str_repeat recebe o que você quer repetir e quantas vezes quer repetir.
    ]);

    // ASSER :: VERIFICAR
    $request->assertSessionHasErrors([
        "questions" => "Tem certeza de que isso é uma pergunta? Está faltando o ponto de interrogação no final.",
    ]);

    assertDatabaseCount('tb_questions', 0);

});
