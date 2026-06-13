<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Camiseta;
use App\Models\Talla;

class TodoCamisetasSeeder extends Seeder
{
    public function run(): void
    {
        // Tallas
        $s  = Talla::create(['nombre' => 'S']);
        $m  = Talla::create(['nombre' => 'M']);
        $l  = Talla::create(['nombre' => 'L']);
        $xl = Talla::create(['nombre' => 'XL']);

        // Clientes
        $minutos = Cliente::create([
            'nombre_comercial'  => '90minutos',
            'rut'               => '76.111.222-3',
            'direccion'         => 'Providencia, Santiago',
            'tipo'              => 'Preferencial',
            'contacto_nombre'   => 'Juan Pérez',
            'contacto_email'    => 'juan@90minutos.cl',
            'porcentaje_oferta' => 15.00,
        ]);

        $tdeportes = Cliente::create([
            'nombre_comercial'  => 'tdeportes',
            'rut'               => '76.333.444-5',
            'direccion'         => 'Las Condes, Santiago',
            'tipo'              => 'Regular',
            'contacto_nombre'   => 'María López',
            'contacto_email'    => 'maria@tdeportes.cl',
            'porcentaje_oferta' => 0,
        ]);

        // Camisetas 90minutos (Preferencial)
        $c1 = Camiseta::create([
            'titulo'          => 'Camiseta Local 2025 – Colo-Colo',
            'club'            => 'Colo-Colo',
            'pais'            => 'Chile',
            'tipo'            => 'Local',
            'color'           => 'Blanco y Negro',
            'precio'          => 42000,
            'precio_oferta'   => 35000,
            'detalles'        => 'Centenario del Cacique',
            'codigo_producto' => 'CC2025L',
            'cliente_id'      => $minutos->id,
        ]);

        $c2 = Camiseta::create([
            'titulo'          => 'Camiseta Local 2025 – Universidad de Chile',
            'club'            => 'Universidad de Chile',
            'pais'            => 'Chile',
            'tipo'            => 'Local',
            'color'           => 'Azul',
            'precio'          => 43000,
            'precio_oferta'   => 36000,
            'detalles'        => 'La U rompe la mala racha',
            'codigo_producto' => 'UCH2025L',
            'cliente_id'      => $minutos->id,
        ]);

        $c3 = Camiseta::create([
            'titulo'          => 'Camiseta Local 2025 – Selección Chilena',
            'club'            => 'Selección Chilena',
            'pais'            => 'Chile',
            'tipo'            => 'Local',
            'color'           => 'Rojo',
            'precio'          => 45000,
            'precio_oferta'   => 38000,
            'detalles'        => 'Clasificatorias 2026',
            'codigo_producto' => 'SCL2025L',
            'cliente_id'      => $minutos->id,
        ]);

        $c4 = Camiseta::create([
            'titulo'          => 'Camiseta Local 2025 – Barcelona',
            'club'            => 'FC Barcelona',
            'pais'            => 'España',
            'tipo'            => 'Local',
            'color'           => 'Azulgrana',
            'precio'          => 55000,
            'precio_oferta'   => 47000,
            'detalles'        => 'Temporada 2024-2025',
            'codigo_producto' => 'FCB2025L',
            'cliente_id'      => $minutos->id,
        ]);

        // Camisetas tdeportes (Regular)
        $c5 = Camiseta::create([
            'titulo'          => 'Camiseta Visita 2025 – Real Madrid',
            'club'            => 'Real Madrid',
            'pais'            => 'España',
            'tipo'            => 'Visita',
            'color'           => 'Negro y Dorado',
            'precio'          => 55000,
            'precio_oferta'   => null,
            'detalles'        => 'Temporada 2024-2025',
            'codigo_producto' => 'RMA2025V',
            'cliente_id'      => $tdeportes->id,
        ]);

        $c6 = Camiseta::create([
            'titulo'          => 'Camiseta Local 2025 – Inter Miami',
            'club'            => 'Inter Miami CF',
            'pais'            => 'Estados Unidos',
            'tipo'            => 'Local',
            'color'           => 'Rosa y Negro',
            'precio'          => 52000,
            'precio_oferta'   => null,
            'detalles'        => 'Temporada MLS 2025',
            'codigo_producto' => 'MIA2025L',
            'cliente_id'      => $tdeportes->id,
        ]);

        $c7 = Camiseta::create([
            'titulo'          => 'Camiseta Local 2025 – Universidad Católica',
            'club'            => 'Universidad Católica',
            'pais'            => 'Chile',
            'tipo'            => 'Local',
            'color'           => 'Blanco y Cruzada',
            'precio'          => 41000,
            'precio_oferta'   => null,
            'detalles'        => 'Temporada 2025',
            'codigo_producto' => 'UC2025L',
            'cliente_id'      => $tdeportes->id,
        ]);

        $c8 = Camiseta::create([
            'titulo'          => 'Camiseta Niño Local 2025 – Colo-Colo',
            'club'            => 'Colo-Colo',
            'pais'            => 'Chile',
            'tipo'            => 'Niño',
            'color'           => 'Blanco y Negro',
            'precio'          => 32000,
            'precio_oferta'   => null,
            'detalles'        => 'Tallas infantiles',
            'codigo_producto' => 'CC2025N',
            'cliente_id'      => $tdeportes->id,
        ]);

        // Asignar tallas
        $c1->tallas()->attach([$s->id, $m->id, $l->id, $xl->id]);
        $c2->tallas()->attach([$s->id, $m->id, $l->id]);
        $c3->tallas()->attach([$s->id, $m->id, $l->id, $xl->id]);
        $c4->tallas()->attach([$m->id, $l->id, $xl->id]);
        $c5->tallas()->attach([$m->id, $l->id]);
        $c6->tallas()->attach([$s->id, $m->id, $l->id, $xl->id]);
        $c7->tallas()->attach([$m->id, $l->id]);
        $c8->tallas()->attach([$s->id, $m->id]);
    }
}
