<?php
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    parse_str($argv[1], $_GET);
}
$key = 'FL_SEED_TOKEN_2024';
if (!isset($_GET['key']) || $_GET['key'] !== $key) {
    status_header(403);
    echo 'Forbidden';
    exit;
}
require_once dirname(__FILE__, 4) . '/wp-load.php';

$categories = [
    'ropa' => [
        'name' => 'Ropa Standard',
        'intro' => 'Listado de prendas desechables fabricadas en SMS impermeable con refuerzos y puños tejidos para áreas quirúrgicas.',
        'families' => [
            [
                'slug' => 'bata-quirurgica-standard',
                'title' => 'Bata Quirúrgica',
                'content' => '<p>Tela no tejida, impermeable a la penetración de líquidos y fluidos, puños ajustables, cuatro cinturones y refuerzo en pecho y mangas.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, Talla, GSM',
                'rows' => [
                    '["202321","060.231.0674","✓","S","30"]',
                    '["202332","060.231.0666","✓","M","30"]',
                    '["202333","060.231.0641","✓","L","30"]',
                    '["202334","060.231.0658","✓","XL","30"]',
                    '["202322","060.231.0807","X","M","30"]',
                    '["202323","060.231.0815","X","L","30"]',
                    '["202324","060.231.0823","X","XL","30"]',
                ],
            ],
            [
                'slug' => 'bata-aislamiento-standard',
                'title' => 'Bata Aislamiento',
                'content' => '<p>Tela no tejida impermeable con puños ajustables y cuatro cintas posteriores.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["201320","X","Unitalla","30"]',
                ],
            ],
            [
                'slug' => 'bata-paciente-standard',
                'title' => 'Bata Paciente',
                'content' => '<p>Tela no tejida impermeable con mangas tipo kimono, escote sesgado con cinta y dos cinturones.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["203120","X","Unitalla","30"]',
                ],
            ],
            [
                'slug' => 'uniforme-quirurgico-standard',
                'title' => 'Uniforme Quirúrgico',
                'content' => '<p>Juego de camisa y pantalón desechable.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["507920","X","Unitalla","30"]',
                ],
            ],
            [
                'slug' => 'set-quirurgico-standard',
                'title' => 'Set Quirúrgico',
                'content' => '<p>Bota con plantilla, gorro de cirujano, cubrebocas, camisa y pantalón.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["508920","X","Unitalla","30"]',
                ],
            ],
        ],
    ],
    'accesorios' => [
        'name' => 'Accesorios Standard',
        'intro' => 'Lista de accesorios quirúrgicos desechables para personal y pacientes.',
        'families' => [
            [
                'slug' => 'gorro-paciente',
                'title' => 'Gorro para Paciente',
                'content' => '<p>Polipropileno no tejido con elástico alrededor del borde.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["506921","060.439.0054","S"]',
                    '["506922","060.439.0070","M"]',
                    '["506923","060.439.0088","L"]',
                ],
            ],
            [
                'slug' => 'gorro-cirujano',
                'title' => 'Gorro de Cirujano',
                'content' => '<p>Polipropileno no tejido con cintas de ajuste distal.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["504920","060.439.0039","Unitalla"]',
                ],
            ],
            [
                'slug' => 'cubrezapato',
                'title' => 'Cubrezapato Simple',
                'content' => '<p>Cobertura con elástico, color azul.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["503920","—","Unitalla"]',
                ],
            ],
            [
                'slug' => 'bota-plantilla',
                'title' => 'Bota con Plantilla',
                'content' => '<p>Bota con plantilla integrada, color azul.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["505921","—","Unitalla"]',
                ],
            ],
            [
                'slug' => 'bota-quirurgica',
                'title' => 'Bota Quirúrgica',
                'content' => '<p>Bota con lazos, color azul.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["505920","060.130.0015","Unitalla"]',
                ],
            ],
            [
                'slug' => 'cubrebocas-simple',
                'title' => 'Cubrebocas Simple',
                'content' => '<p>Dos capas con banda elástica.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["604920","060.621.0524","Unitalla"]',
                ],
            ],
            [
                'slug' => 'cubrebocas-3-capas',
                'title' => 'Cubrebocas 3 Capas (Azul)',
                'content' => '<p>Elástico en oreja, tres capas.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["601920","060.621.0656","Unitalla"]',
                ],
            ],
            [
                'slug' => 'cubrebocas-3-capas-negro',
                'title' => 'Cubrebocas 3 Capas (Negro)',
                'content' => '<p>Versión color negro con tres capas.</p>',
                'headers' => 'Código, Clave Sector Salud, Talla',
                'rows' => [
                    '["603920","060.621.0656","Unitalla"]',
                ],
            ],
        ],
    ],
    'paquetes-standard' => [
        'name' => 'Paquetes Quirúrgicos Standard',
        'intro' => 'Kits estándar para cirugías generales, cesáreas y partos.',
        'families' => [
            [
                'slug' => 'paquete-basico',
                'title' => 'Paquete Básico',
                'content' => '<p>Incluye 3 batas de cirujano, 1 bata de instrumentista, campos absorbentes y cubiertas para mesa.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                'rows' => [
                    '["313130","060.231.0575","✓","30"]',
                ],
            ],
            [
                'slug' => 'kit-cirugia-mayor',
                'title' => 'Kit Cirugía Mayor',
                'content' => '<p>Incluye 2 batas de cirujano, 1 bata de instrumentista, campos adhesivos y bolsa RPBI.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                'rows' => [
                    '["310130","060.231.0609","✓","30"]',
                ],
            ],
            [
                'slug' => 'cirugia-universal',
                'title' => 'Paquete Cirugía Universal',
                'content' => '<p>Kit completo con campos laterales, fenestrado y cubiertas reforzadas.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                'rows' => [
                    '["313130","060.231.0591","✓","30"]',
                ],
            ],
            [
                'slug' => 'cesarea-standard',
                'title' => 'Paquete Cesárea',
                'content' => '<p>Diseñado para cesárea con 6 campos simples y hoja fenestrada.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                'rows' => [
                    '["307130","060.231.0583","✓","30"]',
                ],
            ],
            [
                'slug' => 'paquete-parto',
                'title' => 'Paquete Parto',
                'content' => '<p>Incluye 2 batas, campos y cubiertas para mesa de riñón.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                'rows' => [
                    '["310130","060.231.0609","✓","30"]',
                ],
            ],
        ],
    ],
    'paquetes-individuales' => [
        'name' => 'Paquetes Individuales',
        'intro' => 'Componentes individuales estériles para complementar procedimientos.',
        'families' => [
            [
                'slug' => 'campo-simple',
                'title' => 'Campo Simple',
                'content' => '<p>Campo desechable 90 x 90 cm.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, Medida',
                'rows' => [
                    '["333130","060.231.0617","✓","90 x 90 cm"]',
                ],
            ],
            [
                'slug' => 'campo-hendido',
                'title' => 'Campo Hendido',
                'content' => '<p>Campo 45 x 45 cm para otorrino/anestesia.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, Medida',
                'rows' => [
                    '["343930","060.231.0633","✓","45 x 45 cm"]',
                ],
            ],
            [
                'slug' => 'sabana-especial',
                'title' => 'Sábana Especial',
                'content' => '<p>Sábanas de 1.8 x 1.2 m / 2.1 x 1.2 m.</p>',
                'headers' => 'Código, Clave Sector Salud, Estéril, Medida',
                'rows' => [
                    '["340920","060.231.0633","✓","1.8 m x 1.2 m"]',
                ],
            ],
        ],
    ],
    'ropa-premium' => [
        'name' => 'Ropa Premium',
        'intro' => 'Prendas con puños de algodón, velcro y raglán para máxima protección.',
        'families' => [
            [
                'slug' => 'bata-quirurgica-premium',
                'title' => 'Bata Quirúrgica Premium',
                'content' => '<p>Tela no tejida impermeable con puños de algodón, cuatro cinturones y mangas raglán.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["207431","√","S","35"]',
                    '["207432","√","M","35"]',
                    '["207433","√","L","35"]',
                    '["207434","√","XL","35"]',
                ],
            ],
            [
                'slug' => 'bata-aislamiento-premium',
                'title' => 'Bata Aislamiento Premium',
                'content' => '<p>Tela impermeable con velcro posterior y mangas raglán.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["204921","√","S","35"]',
                    '["204922","√","M","35"]',
                    '["204923","√","L","35"]',
                    '["204924","√","XL","35"]',
                ],
            ],
            [
                'slug' => 'bata-paciente-premium',
                'title' => 'Bata Paciente Premium',
                'content' => '<p>Kimono impermeable con mangas tipo japonés y dos cinturones.</p>',
                'headers' => 'Código, Estéril, Talla, GSM',
                'rows' => [
                    '["206420","√","Unitalla","35"]',
                ],
            ],
        ],
    ],
    'paquetes-premium' => [
        'name' => 'Paquetes Quirúrgicos Premium',
        'intro' => 'Kits con refuerzos absorbentes, bolsas RPBI y componentes adhesivos.',
        'families' => [
            [
                'slug' => 'kit-cirugia-mayor-ii',
                'title' => 'Kit Cirugía Mayor II',
                'content' => '<p>Incluye 2 batas, campos laminados, bolsa RPBI y bolsa para suturas.</p>',
                'headers' => 'Código, Estéril, GSM',
                'rows' => [
                    '["306930","√","35/45"]',
                ],
            ],
            [
                'slug' => 'paquete-parto-ii',
                'title' => 'Paquete Parto II',
                'content' => '<p>Contiene fluid bag, cubiertas impermeables y manta para recién nacido.</p>',
                'headers' => 'Código, Estéril, GSM',
                'rows' => [
                    '["311330","√","35/45"]',
                ],
            ],
            [
                'slug' => 'paquete-cirugia-universal-ii',
                'title' => 'Paquete Cirugía Universal II',
                'content' => '<p>Incluye aislamiento, tubo holders, suture bag y cubiertas adhesivas.</p>',
                'headers' => 'Código, Estéril, GSM',
                'rows' => [
                    '["311330","√","35/45"]',
                ],
            ],
            [
                'slug' => 'paquete-cirugia-universal-iii',
                'title' => 'Paquete Cirugía Universal III',
                'content' => '<p>Kit con campos laminados, reforzados y bolsa de suturas.</p>',
                'headers' => 'Código, Estéril, GSM',
                'rows' => [
                    '["303430","√","35/45"]',
                ],
            ],
            [
                'slug' => 'kit-cesarea-ii',
                'title' => 'Kit Cesárea II',
                'content' => '<p>Incluye bolsa de fluidos, campos adhesivos y hoja fenestrada con cord holder.</p>',
                'headers' => 'Código, Estéril, GSM',
                'rows' => [
                    '["308330","√","35/45"]',
                ],
            ],
        ],
    ],
    'esterilizacion' => [
        'name' => 'Esterilización y Protecciones',
        'intro' => 'Bolsas para esterilización y overoles Tyvek.',
        'families' => [
            [
                'slug' => 'bolsa-esterilizacion',
                'title' => 'Bolsas para Esterilización',
                'content' => '<p>Rollos para esterilización con indicadores para EO.</p>',
                'headers' => 'Código, Medida',
                'rows' => [
                    '["703950","10 cm x 200 m"]',
                    '["704950","20 cm x 200 m"]',
                    '["705950","25 cm x 200 m"]',
                    '["706950","30 cm x 200 m"]',
                    '["707950","40 cm x 200 m"]',
                    '["708950","50 cm x 200 m"]',
                ],
            ],
            [
                'slug' => 'tyvek-overol',
                'title' => 'Overol Tyvek Laminado',
                'content' => '<p>Overol con capucha, cubrezapatos y solapa, fabricado en Tyvek.</p>',
                'headers' => 'Código, Talla, GSM',
                'rows' => [
                    '["101722","M","50/65"]',
                    '["101723","L","50/65"]',
                    '["101724","XL","50/65"]',
                    '["101725","XXL","50/65"]',
                    '["101726","3XL","50/65"]',
                ],
            ],
        ],
    ],
];

foreach ($categories as $slug => $data) {
    echo 'Processing ' . $slug . ': ';
    $term = get_term_by('slug', $slug, 'fl_catalog_category');
    if (!$term) {
        $result = wp_insert_term($data['name'], 'fl_catalog_category', ['slug' => $slug]);
        if (is_wp_error($result)) {
            echo 'error: ' . $result->get_error_message() . PHP_EOL;
            continue;
        }
        $term_id = $result['term_id'];
        echo 'created' . PHP_EOL;
    } else {
        $term_id = $term->term_id;
        echo 'updated' . PHP_EOL;
    }
    update_term_meta($term_id, 'fl_catalog_intro', wp_kses_post($data['intro']));

    foreach ($data['families'] as $family) {
        $existing = get_page_by_path($family['slug'], OBJECT, 'fl_catalog_family');
        if ($existing) {
            $post_id = $existing->ID;
        } else {
            $post_id = wp_insert_post(
                [
                    'post_type' => 'fl_catalog_family',
                    'post_title' => $family['title'],
                    'post_name' => $family['slug'],
                    'post_content' => $family['content'],
                    'post_status' => 'publish',
                ]
            );
        }
        if (is_wp_error($post_id)) {
            continue;
        }
        wp_set_post_terms($post_id, [$term_id], 'fl_catalog_category', false);
        update_post_meta($post_id, '_fl_spec_headers', sanitize_text_field($family['headers']));
        update_post_meta($post_id, '_fl_spec_rows', implode("\n", $family['rows']));
    }
}

echo 'Expanded catalog seeded.';
