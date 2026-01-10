<?php
/**
 * Class Florence_Catalog
 * Handles data fetching and normalization for the JS-powered catalog.
 */

class Florence_Catalog
{
    /**
     * Get the full catalog dataset as an array.
     */
    public static function get_catalog_data()
    {
        $products = [];

        $categories_data = [
            'ropa' => [
                'name_es' => 'Batas de Aislamiento y Quirúrgicas',
                'name_en' => 'Isolation & Surgical Gowns',
                'families' => [
                    [
                        'slug' => 'bata-quirurgica-standard',
                        'title_es' => 'Bata Quirúrgica',
                        'title_en' => 'Surgical Gown',
                        'content_es' => '<p>Tela no tejida, impermeable a la penetración de líquidos y fluidos, puños ajustables, cuatro cinturones y refuerzo en pecho y mangas.</p>',
                        'content_en' => '<p>Non-woven fabric, impermeable to liquids and fluids, adjustable cuffs, four belts, and reinforcement in chest and sleeves.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, Talla, GSM',
                        'rows' => [
                            ["202321", "060.231.0674", "✓", "S", "30"],
                            ["202332", "060.231.0666", "✓", "M", "30"],
                            ["202333", "060.231.0641", "✓", "L", "30"],
                            ["202334", "060.231.0658", "✓", "XL", "30"],
                            ["202322", "060.231.0807", "X", "M", "30"],
                            ["202323", "060.231.0815", "X", "L", "30"],
                            ["202324", "060.231.0823", "X", "XL", "30"],
                        ],
                    ],
                    [
                        'slug' => 'bata-aislamiento-standard',
                        'title_es' => 'Bata Aislamiento',
                        'title_en' => 'Isolation Gown',
                        'content_es' => '<p>Tela no tejida impermeable con puños ajustables y cuatro cintas posteriores.</p>',
                        'content_en' => '<p>Non-woven impermeable fabric with adjustable cuffs and four back ties.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["201320", "X", "Unitalla", "30"],
                        ],
                    ],
                    [
                        'slug' => 'bata-paciente-standard',
                        'title_es' => 'Bata Paciente',
                        'title_en' => 'Patient Gown',
                        'content_es' => '<p>Tela no tejida impermeable con mangas tipo kimono, escote sesgado con cinta y dos cinturones.</p>',
                        'content_en' => '<p>Non-woven impermeable fabric with kimono-style sleeves, biased neckline with tie, and two belts.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["203120", "X", "Unitalla", "30"],
                        ],
                    ],
                    [
                        'slug' => 'uniforme-quirurgico-standard',
                        'title_es' => 'Uniforme Quirúrgico',
                        'title_en' => 'Scrub Suit',
                        'content_es' => '<p>Juego de camisa y pantalón desechable.</p>',
                        'content_en' => '<p>Disposable shirt and pants set.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["507920", "X", "Unitalla", "30"],
                        ],
                    ],
                    [
                        'slug' => 'set-quirurgico-standard',
                        'title_es' => 'Set Quirúrgico',
                        'title_en' => 'Surgical Set',
                        'content_es' => '<p>Bota con plantilla, gorro de cirujano, cubrebocas, camisa y pantalón.</p>',
                        'content_en' => '<p>Boot with sole, surgeon cap, face mask, shirt, and pants.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["508920", "X", "Unitalla", "30"],
                        ],
                    ],
                ],
            ],
            'accesorios' => [
                'name_es' => 'Guantes y Accesorios',
                'name_en' => 'Gloves & Accessories',
                'families' => [
                    [
                        'slug' => 'gorro-paciente',
                        'title_es' => 'Gorro para Paciente',
                        'title_en' => 'Patient Cap',
                        'content_es' => '<p>Polipropileno no tejido con elástico alrededor del borde.</p>',
                        'content_en' => '<p>Non-woven polypropylene with elastic around the edge.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["506921", "060.439.0054", "S"],
                            ["506922", "060.439.0070", "M"],
                            ["506923", "060.439.0088", "L"],
                        ],
                    ],
                    [
                        'slug' => 'gorro-cirujano',
                        'title_es' => 'Gorro de Cirujano',
                        'title_en' => 'Surgeon Cap',
                        'content_es' => '<p>Polipropileno no tejido con cintas de ajuste distal.</p>',
                        'content_en' => '<p>Non-woven polypropylene with distal adjustment ties.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["504920", "060.439.0039", "Unitalla"],
                        ],
                    ],
                    [
                        'slug' => 'cubrezapato',
                        'title_es' => 'Cubrezapato Simple',
                        'title_en' => 'Shoe Cover',
                        'content_es' => '<p>Cobertura con elástico, color azul.</p>',
                        'content_en' => '<p>Elastic opening, blue color.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["503920", "—", "Unitalla"],
                        ],
                    ],
                    [
                        'slug' => 'bota-plantilla',
                        'title_es' => 'Bota con Plantilla',
                        'title_en' => 'Boot Cover with Sole',
                        'content_es' => '<p>Bota con plantilla integrada, color azul.</p>',
                        'content_en' => '<p>Boot with integrated sole, blue color.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["505921", "—", "Unitalla"],
                        ],
                    ],
                    [
                        'slug' => 'bota-quirurgica',
                        'title_es' => 'Bota Quirúrgica',
                        'title_en' => 'Surgical Boot',
                        'content_es' => '<p>Bota con lazos, color azul.</p>',
                        'content_en' => '<p>Boot with ties, blue color.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["505920", "060.130.0015", "Unitalla"],
                        ],
                    ],
                    [
                        'slug' => 'cubrebocas-simple',
                        'title_es' => 'Cubrebocas Simple',
                        'title_en' => 'Simple Face Mask',
                        'content_es' => '<p>Dos capas con banda elástica.</p>',
                        'content_en' => '<p>Two layers with elastic band.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["604920", "060.621.0524", "Unitalla"],
                        ],
                    ],
                    [
                        'slug' => 'cubrebocas-3-capas',
                        'title_es' => 'Cubrebocas 3 Capas (Azul)',
                        'title_en' => '3-Ply Face Mask (Blue)',
                        'content_es' => '<p>Elástico en oreja, tres capas.</p>',
                        'content_en' => '<p>Ear loop, three layers.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["601920", "060.621.0656", "Unitalla"],
                        ],
                    ],
                    [
                        'slug' => 'cubrebocas-3-capas-negro',
                        'title_es' => 'Cubrebocas 3 Capas (Negro)',
                        'title_en' => '3-Ply Face Mask (Black)',
                        'content_es' => '<p>Versión color negro con tres capas.</p>',
                        'content_en' => '<p>Black version, three layers.</p>',
                        'headers' => 'Código, Clave Sector Salud, Talla',
                        'rows' => [
                            ["603920", "060.621.0656", "Unitalla"],
                        ],
                    ],
                ],
            ],
            'paquetes-standard' => [
                'name_es' => 'Campos y Paquetes de Procedimiento',
                'name_en' => 'Drapes & Procedure Packs',
                'families' => [
                    [
                        'slug' => 'paquete-basico',
                        'title_es' => 'Paquete Básico',
                        'title_en' => 'Basic Pack',
                        'content_es' => '<p>Incluye 3 batas de cirujano, 1 bata de instrumentista, campos absorbentes y cubiertas para mesa.</p>',
                        'content_en' => '<p>Includes 3 surgeon gowns, 1 nurse gown, absorbent drapes, and table covers.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                        'rows' => [
                            ["313130", "060.231.0575", "✓", "30"],
                        ],
                    ],
                    [
                        'slug' => 'kit-cirugia-mayor',
                        'title_es' => 'Kit Cirugía Mayor',
                        'title_en' => 'Major Surgery Kit',
                        'content_es' => '<p>Incluye 2 batas de cirujano, 1 bata de instrumentista, campos adhesivos y bolsa RPBI.</p>',
                        'content_en' => '<p>Includes 2 surgeon gowns, 1 nurse gown, adhesive drapes, and biohazard bag.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                        'rows' => [
                            ["310130", "060.231.0609", "✓", "30"],
                        ],
                    ],
                    [
                        'slug' => 'cirugia-universal',
                        'title_es' => 'Paquete Cirugía Universal',
                        'title_en' => 'Universal Surgery Pack',
                        'content_es' => '<p>Kit completo con campos laterales, fenestrado y cubiertas reforzadas.</p>',
                        'content_en' => '<p>Complete kit with side drapes, fenestrated drape, and reinforced covers.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                        'rows' => [
                            ["313130", "060.231.0591", "✓", "30"],
                        ],
                    ],
                    [
                        'slug' => 'cesarea-standard',
                        'title_es' => 'Paquete Cesárea',
                        'title_en' => 'C-Section Pack',
                        'content_es' => '<p>Diseñado para cesárea con 6 campos simples y hoja fenestrada.</p>',
                        'content_en' => '<p>Designed for C-Section with 6 simple drapes and fenestrated sheet.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                        'rows' => [
                            ["307130", "060.231.0583", "✓", "30"],
                        ],
                    ],
                    [
                        'slug' => 'paquete-parto',
                        'title_es' => 'Paquete Parto',
                        'title_en' => 'Delivery Pack',
                        'content_es' => '<p>Incluye 2 batas, campos y cubiertas para mesa de riñón.</p>',
                        'content_en' => '<p>Includes 2 gowns, drapes, and back table covers.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, GSM',
                        'rows' => [
                            ["310130", "060.231.0609", "✓", "30"],
                        ],
                    ],
                ],
            ],
            'paquetes-individuales' => [
                'name_es' => 'Campos y Paquetes de Procedimiento (Individuales)',
                'name_en' => 'Drapes & Procedure Packs (Individual)',
                'families' => [
                    [
                        'slug' => 'campo-simple',
                        'title_es' => 'Campo Simple',
                        'title_en' => 'Simple Drape',
                        'content_es' => '<p>Campo desechable 90 x 90 cm.</p>',
                        'content_en' => '<p>Disposable drape 90 x 90 cm.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, Medida',
                        'rows' => [
                            ["333130", "060.231.0617", "✓", "90 x 90 cm"],
                        ],
                    ],
                    [
                        'slug' => 'campo-hendido',
                        'title_es' => 'Campo Hendido',
                        'title_en' => 'Fenestrated Drape',
                        'content_es' => '<p>Campo 45 x 45 cm para otorrino/anestesia.</p>',
                        'content_en' => '<p>Drape 45 x 45 cm for ENT/anesthesia.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, Medida',
                        'rows' => [
                            ["343930", "060.231.0633", "✓", "45 x 45 cm"],
                        ],
                    ],
                    [
                        'slug' => 'sabana-especial',
                        'title_es' => 'Sábana Especial',
                        'title_en' => 'Speciality Sheet',
                        'content_es' => '<p>Sábanas de 1.8 x 1.2 m / 2.1 x 1.2 m.</p>',
                        'content_en' => '<p>Sheets 1.8 x 1.2 m / 2.1 x 1.2 m.</p>',
                        'headers' => 'Código, Clave Sector Salud, Estéril, Medida',
                        'rows' => [
                            ["340920", "060.231.0633", "✓", "1.8 m x 1.2 m"],
                        ],
                    ],
                ],
            ],
            'ropa-premium' => [
                'name_es' => 'Batas de Aislamiento y Quirúrgicas (Premium)',
                'name_en' => 'Isolation & Surgical Gowns (Premium)',
                'families' => [
                    [
                        'slug' => 'bata-quirurgica-premium',
                        'title_es' => 'Bata Quirúrgica Premium',
                        'title_en' => 'Premium Surgical Gown',
                        'content_es' => '<p>Tela no tejida impermeable con puños de algodón, cuatro cinturones y mangas raglán.</p>',
                        'content_en' => '<p>Non-woven impermeable fabric with cotton cuffs, four belts, and raglan sleeves.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["207431", "√", "S", "35"],
                            ["207432", "√", "M", "35"],
                            ["207433", "√", "L", "35"],
                            ["207434", "√", "XL", "35"],
                        ],
                    ],
                    [
                        'slug' => 'bata-aislamiento-premium',
                        'title_es' => 'Bata Aislamiento Premium',
                        'title_en' => 'Premium Isolation Gown',
                        'content_es' => '<p>Tela impermeable con velcro posterior y mangas raglán.</p>',
                        'content_en' => '<p>Impermeable fabric with back velcro and raglan sleeves.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["204921", "√", "S", "35"],
                            ["204922", "√", "M", "35"],
                            ["204923", "√", "L", "35"],
                            ["204924", "√", "XL", "35"],
                        ],
                    ],
                    [
                        'slug' => 'bata-paciente-premium',
                        'title_es' => 'Bata Paciente Premium',
                        'title_en' => 'Premium Patient Gown',
                        'content_es' => '<p>Kimono impermeable con mangas tipo japonés y dos cinturones.</p>',
                        'content_en' => '<p>Impermeable kimono with Japanese-style sleeves and two belts.</p>',
                        'headers' => 'Código, Estéril, Talla, GSM',
                        'rows' => [
                            ["206420", "√", "Unitalla", "35"],
                        ],
                    ],
                ],
            ],
            'paquetes-premium' => [
                'name_es' => 'Campos y Paquetes de Procedimiento (Premium)',
                'name_en' => 'Drapes & Procedure Packs (Premium)',
                'families' => [
                    [
                        'slug' => 'kit-cirugia-mayor-ii',
                        'title_es' => 'Kit Cirugía Mayor II',
                        'title_en' => 'Major Surgery Kit II',
                        'content_es' => '<p>Incluye 2 batas, campos laminados, bolsa RPBI y bolsa para suturas.</p>',
                        'content_en' => '<p>Includes 2 gowns, laminated drapes, biohazard bag, and suture bag.</p>',
                        'headers' => 'Código, Estéril, GSM',
                        'rows' => [
                            ["306930", "√", "35/45"],
                        ],
                    ],
                    [
                        'slug' => 'paquete-parto-ii',
                        'title_es' => 'Paquete Parto II',
                        'title_en' => 'Delivery Pack II',
                        'content_es' => '<p>Contiene fluid bag, cubiertas impermeables y manta para recién nacido.</p>',
                        'content_en' => '<p>Contains fluid bag, impermeable covers, and newborn blanket.</p>',
                        'headers' => 'Código, Estéril, GSM',
                        'rows' => [
                            ["311330", "√", "35/45"],
                        ],
                    ],
                    [
                        'slug' => 'paquete-cirugia-universal-ii',
                        'title_es' => 'Paquete Cirugía Universal II',
                        'title_en' => 'Universal Surgery Pack II',
                        'content_es' => '<p>Incluye aislamiento, tubo holders, suture bag y cubiertas adhesivas.</p>',
                        'content_en' => '<p>Includes isolation drape, tube holders, suture bag, and adhesive covers.</p>',
                        'headers' => 'Código, Estéril, GSM',
                        'rows' => [
                            ["311330", "√", "35/45"],
                        ],
                    ],
                    [
                        'slug' => 'paquete-cirugia-universal-iii',
                        'title_es' => 'Paquete Cirugía Universal III',
                        'title_en' => 'Universal Surgery Pack III',
                        'content_es' => '<p>Kit con campos laminados, reforzados y bolsa de suturas.</p>',
                        'content_en' => '<p>Kit with laminated, reinforced drapes and suture bag.</p>',
                        'headers' => 'Código, Estéril, GSM',
                        'rows' => [
                            ["303430", "√", "35/45"],
                        ],
                    ],
                    [
                        'slug' => 'kit-cesarea-ii',
                        'title_es' => 'Kit Cesárea II',
                        'title_en' => 'C-Section Kit II',
                        'content_es' => '<p>Incluye bolsa de fluidos, campos adhesivos y hoja fenestrada con cord holder.</p>',
                        'content_en' => '<p>Includes fluid collection pouch, adhesive drapes, and fenestrated sheet with cord holder.</p>',
                        'headers' => 'Código, Estéril, GSM',
                        'rows' => [
                            ["308330", "√", "35/45"],
                        ],
                    ],
                ],
            ],
            'esterilizacion' => [
                'name_es' => 'Guantes y Accesorios (Esterilización)',
                'name_en' => 'Gloves & Accessories (Sterilization)',
                'families' => [
                    [
                        'slug' => 'bolsa-esterilizacion',
                        'title_es' => 'Bolsas para Esterilización',
                        'title_en' => 'Sterilization Pouches',
                        'content_es' => '<p>Rollos para esterilización con indicadores para EO.</p>',
                        'content_en' => '<p>Sterilization rolls with EO indicators.</p>',
                        'headers' => 'Código, Medida',
                        'rows' => [
                            ["703950", "10 cm x 200 m"],
                            ["704950", "20 cm x 200 m"],
                            ["705950", "25 cm x 200 m"],
                            ["706950", "30 cm x 200 m"],
                            ["707950", "40 cm x 200 m"],
                            ["708950", "50 cm x 200 m"],
                        ],
                    ],
                    [
                        'slug' => 'tyvek-overol',
                        'title_es' => 'Overol Tyvek Laminado',
                        'title_en' => 'Laminated Tyvek Coverall',
                        'content_es' => '<p>Overol con capucha, cubrezapatos y solapa, fabricado en Tyvek.</p>',
                        'content_en' => '<p>Coverall with hood, boots, and flap, made of Tyvek.</p>',
                        'headers' => 'Código, Talla, GSM',
                        'rows' => [
                            ["101722", "M", "50/65"],
                            ["101723", "L", "50/65"],
                            ["101724", "XL", "50/65"],
                            ["101725", "XXL", "50/65"],
                            ["101726", "3XL", "50/65"],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($categories_data as $cat_key => $cat_data) {
            $cat_name_en = isset($cat_data['name_en']) ? $cat_data['name_en'] : (isset($cat_data['name']) ? $cat_data['name'] : 'Category');
            $cat_name_es = isset($cat_data['name_es']) ? $cat_data['name_es'] : $cat_name_en; // Fallback

            $tier = strpos($cat_key, 'premium') !== false ? 'Premium' : 'Standard';

            foreach ($cat_data['families'] as $family) {
                // Determine specific overrides for masks if needed
                if (stripos($family['slug'], 'cubrebocas') !== false || stripos($family['slug'], 'mask') !== false) {
                    $cat_name_en = 'Face Masks & Respiratory';
                    $cat_name_es = 'Mascarillas y Respiratorios';
                }

                $skus = [];
                $headers = array_map('trim', explode(',', $family['headers']));

                foreach ($family['rows'] as $row_data) {
                    // Create a map of Header -> Value
                    $sku_map = [];
                    foreach ($headers as $index => $h_name) {
                        if (isset($row_data[$index])) {
                            $sku_map[strtolower($h_name)] = $row_data[$index];
                        }
                    }

                    // Extract normalized fields
                    $code = isset($sku_map['código']) ? $sku_map['código'] : (isset($sku_map['codigo']) ? $sku_map['codigo'] : '');
                    $sterile_val = isset($sku_map['estéril']) ? $sku_map['estéril'] : (isset($sku_map['esteril']) ? $sku_map['esteril'] : 'X');
                    $is_sterile = ($sterile_val === '✓' || $sterile_val === '√' || strtolower($sterile_val) === 'si' || strtolower($sterile_val) === 'yes');
                    $size = isset($sku_map['talla']) ? $sku_map['talla'] : (isset($sku_map['medida']) ? $sku_map['medida'] : 'One Size');
                    $gsm = isset($sku_map['gsm']) ? $sku_map['gsm'] : '';
                    $h_code = isset($sku_map['clave sector salud']) ? $sku_map['clave sector salud'] : '';
                    if ($h_code === '—')
                        $h_code = '';

                    $skus[] = [
                        'code' => $code,
                        'sterile' => $is_sterile,
                        'size' => $size,
                        'gsm' => $gsm,
                        'health_code' => $h_code
                    ];
                }

                $all_sizes = array_unique(array_column($skus, 'size'));
                $all_codes = array_column($skus, 'code');
                $is_any_sterile = in_array(true, array_column($skus, 'sterile'));

                $products[] = [
                    'id' => $family['slug'],
                    // English Data (Default)
                    'name' => isset($family['title_en']) ? $family['title_en'] : $family['title'],
                    'category' => $cat_name_en,
                    'tier' => $tier,
                    'type' => self::infer_type($cat_name_en, $family['title_en']),
                    'description' => strip_tags(isset($family['content_en']) ? $family['content_en'] : $family['content']),
                    'content_html' => isset($family['content_en']) ? $family['content_en'] : $family['content'],
                    // Spanish Data
                    'name_es' => isset($family['title_es']) ? $family['title_es'] : $family['slug'],
                    'category_es' => $cat_name_es,
                    'description_es' => strip_tags(isset($family['content_es']) ? $family['content_es'] : ''),
                    'content_html_es' => isset($family['content_es']) ? $family['content_es'] : '',

                    'skus' => $skus,
                    'filters' => [
                        'sizes' => $all_sizes,
                        'codes' => $all_codes,
                        'sterile' => $is_any_sterile,
                    ]
                ];
            }
        }

        return $products;
    }

    private static function infer_category($term_slug, $post_slug)
    {
        // Existing logic... kept for safety but largely replaced by explicit names
        $haystack = $term_slug . ' ' . $post_slug;
        if (strpos($haystack, 'bata') !== false || strpos($haystack, 'uniforme') !== false || strpos($haystack, 'ropa') !== false) {
            return 'Isolation & Surgical Gowns';
        }
        return 'Other';
    }

    private static function infer_type($category, $title)
    {
        if (stripos($title, 'pack') !== false || stripos($title, 'set') !== false || stripos($title, 'kit') !== false || stripos($title, 'paquete') !== false) {
            return 'Pack/Kit';
        }
        if ($category === 'Isolation & Surgical Gowns')
            return 'Garment';
        if ($category === 'Face Masks & Respiratory')
            return 'Accessory';
        if (stripos($title, 'drape') !== false || stripos($title, 'campo') !== false || stripos($title, 'sabana') !== false) {
            return 'Drape/Sheet';
        }
        return 'Accessory';
    }
}
