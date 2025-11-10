<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        Product::insert([
            ['id' => 1,  'name' => 'AZEITE  PORTUGUÊS EXTRA VIRGEM GALLO 500ML', 'price' => 20.49, 'qty_stock' => 2],
            ['id' => 2,  'name' => 'BEBIDA ENERGÉTICA VIBE 2L', 'price' => 8.99, 'qty_stock' => 659],
            ['id' => 3,  'name' => 'ENERGÉTICO RED BULL ENERGY DRINK 250ML', 'price' => 7.29, 'qty_stock' => 909],
            ['id' => 4,  'name' => 'ENERGÉTICO RED BULL ENERGY DRINK 355ML', 'price' => 10.79, 'qty_stock' => 159],
            ['id' => 5,  'name' => 'ENERGÉTICO RED BULL ENERGY DRINK SEM AÇÚCAR 250ML', 'price' => 7.49, 'qty_stock' => 659],
            ['id' => 6,  'name' => 'ÁGUA MINERAL BONAFONT SEM GÁS 1', 'price' => 2.39, 'qty_stock' => 909],
            ['id' => 7,  'name' => 'FILME DE PVC WYDA 28CMX15M', 'price' => 3.99, 'qty_stock' => 160],
            ['id' => 8,  'name' => 'FILME DE PVC PRATSY 15M', 'price' => 4.39, 'qty_stock' => 410],
            ['id' => 9,  'name' => 'ROLO DE PAPEL ALUMÍNIO WYDA 30CMX7', 'price' => 5.79, 'qty_stock' => 660],
            ['id' => 10, 'name' => 'ÁGUA MINERAL SEM GÁS MINALBA 1', 'price' => 2.29, 'qty_stock' => 910],
            ['id' => 11, 'name' => 'GUARDANAPO GRAND HOTEL SCOTT 24X24CM C/ 50UN', 'price' => 4.39, 'qty_stock' => 160],
            ['id' => 12, 'name' => 'GUARDANAPO DIA A DIA SCOTT 24X22CM C/ 50UN', 'price' => 2.59, 'qty_stock' => 411],
            ['id' => 13, 'name' => 'GUARDANAPO FOLHA DUPLA SNOB 23', 'price' => 4.25, 'qty_stock' => 411],
            ['id' => 14, 'name' => 'GUARDANAPO FOLHA SIMPLES SNOB 24X22CM C/ 50UN', 'price' => 2.19, 'qty_stock' => 661],
            ['id' => 15, 'name' => 'PAPEL TOALHA SNOB C/ 2UN', 'price' => 5.39, 'qty_stock' => 912],
            ['id' => 16, 'name' => 'PAPEL HIGIÊNICO NEVE NEUTRO FOLHA DUPLA 30M C/ 4UN', 'price' => 7.49, 'qty_stock' => 412],
            ['id' => 17, 'name' => 'PAPEL HIGIÊNICO PERSONAL FOLHA DUPLA 30M C/ 4UN', 'price' => 4.79, 'qty_stock' => 662],
            ['id' => 18, 'name' => 'AMACIANTE YPÊ BLUE 2L', 'price' => 8.99, 'qty_stock' => 913],
            ['id' => 19, 'name' => 'AMACIANTE YPÊ CONCENTRADO 500ML', 'price' => 6.99, 'qty_stock' => 913],
            ['id' => 20, 'name' => 'DETERGENTE LÍQUIDO YPÊ NEUTRO 500ML', 'price' => 2.19, 'qty_stock' => 663],
            ['id' => 21, 'name' => 'DETERGENTE LÍQUIDO YPÊ LIMÃO 500ML', 'price' => 2.09, 'qty_stock' => 663],
            ['id' => 22, 'name' => 'DESINFETANTE PINHO BRIL PINHO 500ML', 'price' => 4.39, 'qty_stock' => 414],
            ['id' => 23, 'name' => 'LIMPADOR CIF CREMOSO ORIGINAL 500ML', 'price' => 7.99, 'qty_stock' => 164],
            ['id' => 24, 'name' => 'ESPONJA DE AÇO ASSOLAN C/ 8UN', 'price' => 4.99, 'qty_stock' => 664],
            ['id' => 25, 'name' => 'ESPONJA MULTIUSO SCOTCH-BRITE C/ 3UN', 'price' => 5.99, 'qty_stock' => 414],
            ['id' => 26, 'name' => 'DESINFETANTE YPÊ LAVANDA 5L', 'price' => 18.90, 'qty_stock' => 164],
            ['id' => 27, 'name' => 'LAVA ROUPAS EM PÓ OMO MULTIAÇÃO 2KG', 'price' => 21.90, 'qty_stock' => 915],
            ['id' => 28, 'name' => 'LAVA ROUPAS LÍQUIDO OMO 3L', 'price' => 32.90, 'qty_stock' => 665],
            ['id' => 29, 'name' => 'ÁLCOOL LÍQUIDO 70° INPM 1L', 'price' => 5.49, 'qty_stock' => 915],
            ['id' => 30, 'name' => 'ÁLCOOL EM GEL 70° 500G', 'price' => 7.99, 'qty_stock' => 665],
            ['id' => 31, 'name' => 'DESODORANTE AEROSOL REXONA ACTIVE DRY 150ML', 'price' => 11.99, 'qty_stock' => 666],
            ['id' => 32, 'name' => 'DESODORANTE AEROSOL REXONA COTTON DRY 150ML', 'price' => 11.99, 'qty_stock' => 416],
            ['id' => 33, 'name' => 'DESODORANTE AEROSOL REXONA BAMBOO 150ML', 'price' => 11.99, 'qty_stock' => 166],
            ['id' => 34, 'name' => 'DESODORANTE AEROSOL NIVEA PROTECT & CARE 150ML', 'price' => 11.99, 'qty_stock' => 416],
            ['id' => 35, 'name' => 'DESODORANTE AEROSOL NIVEA BLACK&WHITE INVISIBLE 150ML', 'price' => 11.99, 'qty_stock' => 666],
            ['id' => 36, 'name' => 'DESODORANTE AEROSOL DOVE ORIGINAL 150ML', 'price' => 13.99, 'qty_stock' => 916],
            ['id' => 37, 'name' => 'DESODORANTE AEROSOL DOVE BEAUTY 150ML', 'price' => 14.99, 'qty_stock' => 169],
            ['id' => 38, 'name' => 'DESODORANTE AEROSOL DOVE PURE 100G', 'price' => 13.19, 'qty_stock' => 419],
            ['id' => 39, 'name' => 'REFRIGERANTE ANTARCTICA GUARANÁ 2L', 'price' => 6.79, 'qty_stock' => 670],
            ['id' => 40, 'name' => 'ÁGUA MINERAL SEM GÁS CRYSTAL GARRAFÃO 5L', 'price' => 7.99, 'qty_stock' => 920],
            ['id' => 41, 'name' => 'REFRIGERANTE H2OH! DE LIMÃO 500ML', 'price' => 3.90, 'qty_stock' => 670],
            ['id' => 42, 'name' => 'DESODORANTE AEROSOL NIVEA SENSITIVE SEM PERFUME 150ML', 'price' => 11.99, 'qty_stock' => 171],
            ['id' => 43, 'name' => 'REFRIGERANTE H2OH! LIMÃO 1', 'price' => 6.99, 'qty_stock' => 921],
            ['id' => 44, 'name' => 'DESODORANTE AEROSOL NIVEA BLACK&WHITE INVISIBLE MASCULINO 150ML', 'price' => 11.99, 'qty_stock' => 171],
            ['id' => 45, 'name' => 'ÁGUA MINERAL PRATA SEM GÁS 1', 'price' => 3.90, 'qty_stock' => 172],
            ['id' => 46, 'name' => 'NÉCTAR MAGUARY DE MARACUJÁ 1L', 'price' => 4.49, 'qty_stock' => 672],
            ['id' => 47, 'name' => 'REFRIGERANTE ANTARCTICA GUARANÁ ZERO 2L', 'price' => 5.79, 'qty_stock' => 923],
            ['id' => 48, 'name' => 'ÁGUA MINERAL SEM GÁS CRYSTAL PET 1', 'price' => 2.59, 'qty_stock' => 173],
            ['id' => 49, 'name' => 'ÁGUA MINERAL BONAFONT SEM GÁS 500ML', 'price' => 1.75, 'qty_stock' => 423],
            ['id' => 50, 'name' => 'DESODORANTE AEROSOL REXONA ANTIBACTERIANO + INVISIBLE PROTECTION FEMININO 150ML', 'price' => 11.99, 'qty_stock' => 673],
        ]);
    }
}
