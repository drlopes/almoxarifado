<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = [
            [
                'code' => 'cddnpc',
                'client' => 'Danone',
                'description' => 'Centro de distribuição da Danone em Poços de Caldas - MG',
            ],
            [
                'code' => 'fbdnpc',
                'client' => 'Danone',
                'description' => 'Fábrica da Danone em Poços de Caldas - MG',
            ],
            [
                'code' => 'fbdlnpc',
                'client' => 'Danone',
                'description' => 'Fábrica da Danone ELN em Poços de Caldas - MG',
            ],
            [
                'code' => 'cddnpa',
                'client' => 'Danone',
                'description' => 'Centro de distribuição da Danone em Pavuna - RJ',
            ],
            // [
            //     'code' => 'cda',
            //     'client' => 'Carrefour',
            //     'description' => 'Centro de distribuição do Carrefour',
            // ],
            // [
            //     'code' => 'cdbr',
            //     'client' => 'Carrefour',
            //     'description' => 'Centro de distribuição do Carrefour',
            // ],
            // [
            //     'code' => 'cdd',
            //     'client' => 'Carrefour',
            //     'description' => 'Centro de distribuição do Carrefour',
            // ],
            // [
            //     'code' => 'cdi-osasco',
            //     'client' => 'Carrefour',
            //     'description' => 'Centro de distribuição do Carrefour',
            // ],
            // [
            //     'code' => 'agpriju',
            //     'client' => 'Privalia',
            //     'description' => 'Privalia em Jundiaí - SP',
            // ],
            // [
            //     'code' => 'cdpriex',
            //     'client' => 'Privalia',
            //     'description' => 'Centro de distribuição da Privalia em Extrema - MG',
            // ],
            // [
            //     'code' => 'aghnkju',
            //     'client' => 'Henkel',
            //     'description' => 'Henkel em Jundiaí - SP',
            // ],
            // [
            //     'code' => 'fbmersp',
            //     'client' => 'Meritor',
            //     'description' => 'Fábrica da Meritor',
            // ],
            // [
            //     'code' => 'agnivju',
            //     'client' => 'Nivea',
            //     'description' => 'Nivea em Jundiaí - SP',
            // ],
            // [
            //     'code' => 'cdnivex',
            //     'client' => 'Nivea',
            //     'description' => 'Centro de distribuição da Nivea em Extrema - MG',
            // ],
            // [
            //     'code' => 'fbamblv',
            //     'client' => 'Ambev',
            //     'description' => 'Fábrica da Ambev',
            // ],
            // [
            //     'code' => 'agmwmja',
            //     'client' => 'MWM International',
            //     'description' => 'MWM',
            // ],
            // [
            //     'code' => 'agshiju',
            //     'client' => 'Shiseido',
            //     'description' => 'Armazém da Shiseido em Jundiaí',
            // ],
            // [
            //     'code' => 'cdjjnod',
            //     'client' => 'Johnson & Johnson',
            //     'description' => 'Centro de distribuição da Johnson & Johnson',
            // ],
            // [
            //     'code' => 'cdheiex',
            //     'client' => 'Heineken',
            //     'description' => 'Centro de distribuição da Heineken em Extrema - MG',
            // ],
            // [
            //     'code' => 'cdcarma',
            //     'client' => 'Cargil',
            //     'description' => 'Centro de distribuição da Cargil em Maringá - PR',
            // ],
            // [
            //     'code' => 'cddiaex',
            //     'client' => 'Diageo',
            //     'description' => 'Centro de distribuição da Diageo em Extrema - MG',
            // ],
            // [
            //     'code' => 'cdypeex',
            //     'client' => 'Ypê',
            //     'description' => 'Centro de distribuição da Ypê em Extrema - MG',
            // ],
            // [
            //     'code' => 'agdocju',
            //     'client' => 'Docile',
            //     'description' => 'Armazém da Docile em Jundiaí - SP',
            // ],
            // [
            //     'code' => 'cddocex',
            //     'client' => 'Docile',
            //     'description' => 'Centro de distribuição da Docile em Extrema - MG',
            // ],
            // [
            //     'code' => 'agicorj',
            //     'client' => 'Iconic',
            //     'description' => 'Armazém da Iconic RJ',
            // ],
            // [
            //     'code' => 'cdeslse',
            //     'client' => 'Estee Lauder',
            //     'description' => 'Centro de distribuição da Estee Lauder em Serra - ES',
            // ],
            // [
            //     'code' => 'cdarcex',
            //     'client' => 'Arcor',
            //     'description' => 'Centro de distribuição da Arcor em Extrema - MG',
            // ],
            // [
            //     'code' => 'cdpuig',
            //     'client' => 'Puig',
            //     'description' => 'Centro de distribuição da Puig',
            // ],
            // [
            //     'code' => 'fbunisp',
            //     'client' => 'Unilever',
            //     'description' => 'Fábrica da Unilever',
            // ],
            // [
            //     'code' => 'cdwelex',
            //     'client' => 'Wella',
            //     'description' => 'Centro de distribuição da Wella em Extrema - MG',
            // ]
        ];

        Tenant::insert($tenants);
    }
}
