<?php

namespace Tests\Feature\BusquedaAvanzada;

use Tests\TestCase;

class FormularioTest extends TestCase
{
    /** @test */
    function urlValida() {
        $response = $this->get(route('busqueda_avanzada.formulario'));
        $response->assertStatus(200);
    }
}